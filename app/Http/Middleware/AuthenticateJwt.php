<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateJwt
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Leer solo el payload del token, sin buscar el usuario en la BD
            $payload = JWTAuth::parseToken()->getPayload();
            $userId = $payload->get('sub');
            if (!$userId) {
                return response()->json(['error' => 'Usuario no encontrado'], Response::HTTP_UNAUTHORIZED);
            }
            // Agregar el user_id del token a la solicitud
            $request->attributes->set('user_id', $userId);
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido: ' . $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
