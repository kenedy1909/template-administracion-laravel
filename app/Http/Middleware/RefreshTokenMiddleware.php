<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RefreshTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Verificar si el usuario está autenticado y si el token está próximo a vencer
        if (Auth::check()) {
            $token = $request->user()->currentAccessToken();

            // Verificar si el token está próximo a expirar (puedes ajustar el límite de tiempo según tus necesidades)
            $expirationInMinutes = config('sanctum.expiration') - now()->diffInMinutes($token->created_at);

            $response->headers->set('Token', 'Tiempo ' . $expirationInMinutes);

            if ($expirationInMinutes < config('sanctum.expiration') / 2) {
                $request->user()->tokens()->delete(); // Eliminar el token actual
                $newToken = $request->user()->createToken('TokenRefresh')->plainTextToken;
                $response->headers->set('Token',$newToken);
            }
        }

        return $response;
    }
}
