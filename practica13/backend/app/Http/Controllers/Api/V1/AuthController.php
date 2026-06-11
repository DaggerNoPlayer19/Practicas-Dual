<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends BaseAuthController
{
    #[OA\Post(
        path: '/api/v1/register',
        tags: ['Autenticacion'],
        summary: 'Registrar un usuario',
        responses: [new OA\Response(response: 201, description: 'Usuario registrado')]
    )]
    public function register(Request $request): JsonResponse
    {
        return parent::register($request);
    }

    #[OA\Post(
        path: '/api/v1/login',
        tags: ['Autenticacion'],
        summary: 'Iniciar sesion',
        responses: [
            new OA\Response(response: 200, description: 'Autenticacion exitosa'),
            new OA\Response(response: 401, description: 'Credenciales incorrectas'),
        ]
    )]
    public function login(Request $request): JsonResponse
    {
        return parent::login($request);
    }

    #[OA\Post(
        path: '/api/v1/logout',
        tags: ['Autenticacion'],
        security: [['bearerAuth' => []]],
        summary: 'Cerrar sesion',
        responses: [new OA\Response(response: 200, description: 'Sesion cerrada')]
    )]
    public function logout(Request $request): JsonResponse
    {
        return parent::logout($request);
    }

    #[OA\Get(
        path: '/api/v1/me',
        tags: ['Autenticacion'],
        security: [['bearerAuth' => []]],
        summary: 'Obtener usuario autenticado',
        responses: [new OA\Response(response: 200, description: 'Usuario actual')]
    )]
    public function me(Request $request): JsonResponse
    {
        return parent::me($request);
    }
}
