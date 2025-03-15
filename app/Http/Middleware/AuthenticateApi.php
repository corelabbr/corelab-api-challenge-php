<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Auth::guard('api')->check()) {
                throw new AuthenticationException();
            }

            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => 'Token inválido ou expirado.'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
