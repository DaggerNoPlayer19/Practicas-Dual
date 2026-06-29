# Backend - Practica 06

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
   - `DB_DATABASE=practica6_integrador`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=`
   - `FILESYSTEM_DISK=public`
4. Crear base de datos `practica6_integrador`.
5. Ejecutar migraciones y seeders:
   - `php artisan migrate:fresh --seed`
6. Crear enlace de storage publico:
   - `php artisan storage:link`
7. Iniciar servidor:
   - `php artisan serve --host=127.0.0.1 --port=8000`

## Despliegue web
- La aplicacion publica de Vue se sirve desde `frontend/dist` por medio de las rutas web de Laravel.
- Antes de probar `/`, `/login`, `/catalogo` o `/admin`, compila el frontend con:
  - `cd ../frontend`
  - `npm install`
  - `npm run build`
- Si cambias el frontend, vuelve a ejecutar `npm run build` para regenerar `dist/`.

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

## Usuario admin seed
- `admin@tienda.com`
- `Admin1234`
