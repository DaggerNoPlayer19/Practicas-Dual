# Backend - Practica 05

## Requisitos
- PHP 8.2+
- Composer
- MySQL/MariaDB o SQLite local para pruebas

## Instalacion
1. Entrar a carpeta backend:
   - `cd backend`
2. Instalar dependencias:
   - `composer install`
3. Configurar `.env` segun tu entorno.
4. Ejecutar migraciones y seeders:
   - `php artisan migrate:fresh --seed`
5. Crear enlace de storage publico si usaras imagenes:
   - `php artisan storage:link`
6. Iniciar servidor:
   - `php artisan serve --host=127.0.0.1 --port=8001`

## Endpoints principales
- Publicos:
  - `GET /api/productos`
  - `GET /api/productos/{id}`
  - `POST /api/register`
  - `POST /api/login`
- Autenticados:
  - `GET /api/me`
  - `POST /api/logout`
- Solo admin (`auth:sanctum` + `admin`):
  - `POST /api/productos`
  - `PUT /api/productos/{id}`
  - `DELETE /api/productos/{id}`

## Abilities de token
- `read`: `['ver']`
- `write`: `['ver', 'crear', 'editar', 'eliminar']`

## Usuario admin seed
- `admin@tienda.com`
- `Admin1234`
