<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Checa se a requisição tem um token de API válido no Header
        if (! $request->hasHeader('X-API-TOKEN') || $request->header('X-API-TOKEN') !== config('app.api_token')) {
            return response()->json([
                'message' => 'Invalid or missing API token',
            ], 401);
        }

        return $next($request);
    }
}
