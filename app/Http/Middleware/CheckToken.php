<?php

namespace App\Http\Middleware;

use App\Constants\HttpStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], HttpStatus::HTTP_UNAUTHORIZED);
        }

        $tokenModel = PersonalAccessToken::findToken($token);

        if (!$tokenModel || !isset($tokenModel->tokenable)) {
            return response()->json(['error' => 'Invalid token'], HttpStatus::HTTP_UNAUTHORIZED);
        }

        Auth::setUser($tokenModel->tokenable);

        return $next($request);
    }
}
