<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    /**
     * Verifica que el usuario autenticado tenga alguno de los roles permitidos.
     * Uso en rutas: middleware('role:Administrador')
     *              middleware('role:Administrador,Operador')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $rolEnToken = $payload->get('rol');

            if (!$rolEnToken || !in_array($rolEnToken, $roles)) {
                return response()->json(
                    ['error' => 'No tienes permisos para acceder a este recurso'],
                    Response::HTTP_FORBIDDEN
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Token inválido: ' . $e->getMessage()],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
