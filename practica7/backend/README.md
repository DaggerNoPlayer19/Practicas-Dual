# Backend - Practica 07

## Requisitos
- PHP 8.2+
- Composer
- MySQL/MariaDB (XAMPP)

## Instalacion
1. Entrar a carpeta backend:
   - `cd backend`
2. Instalar dependencias:
   - `composer install`
3. Configurar `.env` (incluido para este proyecto):
   - `DB_DATABASE=practica7_filtros`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=`
   - `FILESYSTEM_DISK=public`
4. Crear base de datos `practica7_filtros`.
5. Ejecutar migraciones y seeders:
   - `php artisan migrate:fresh --seed`
6. Crear enlace de storage publico:
   - `php artisan storage:link`
7. Iniciar servidor:
   - `php artisan serve --host=127.0.0.1 --port=8000`

## Endpoints principales
- Publicos:
  - `GET /api/productos`
  - `GET /api/productos/{id}`
  - `GET /api/categorias`
  - `GET /api/categorias/{categoria}/productos`
  - `POST /api/register`
  - `POST /api/login`
- Autenticados:
  - `GET /api/me`
  - `POST /api/logout`
- Solo admin (`auth:sanctum` + `admin`):
  - `POST /api/productos`
  - `PUT /api/productos/{id}`
  - `DELETE /api/productos/{id}`

## Filtros soportados en productos
- `busqueda`
- `categoria`
- `min`
- `max`
- `orden`
- `dir`
- `pagina`
- `por_pagina`

## Usuario admin seed
- `admin@tienda.com`
- `Admin1234`
