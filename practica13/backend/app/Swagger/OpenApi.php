<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Practica 13 API Versioning y Swagger',
    version: '1.0.0',
    description: 'API REST documentada con OpenAPI 3.0 y versionamiento /api/v1 y /api/v2'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Servidor local'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Token'
)]
#[OA\Tag(name: 'Autenticacion', description: 'Registro, acceso y cierre de sesion')]
#[OA\Tag(name: 'Productos', description: 'Operaciones CRUD y consulta de productos')]
#[OA\Tag(name: 'Pedidos', description: 'Creacion y consulta de pedidos')]
class OpenApi
{
}