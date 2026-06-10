# Practica 11 - Jobs, Queues y Email

Alumno: Alejandro Avalos Espinosa

Estructura:
- `backend/`: API Laravel 12 con Sanctum, CRUD de productos e imagenes.
- `frontend/`: SPA Vue 3 con Router + Pinia + carrito + subida de imagen.

## Funcionalidades cubiertas
- Autenticacion con Sanctum (`login`, `register`, `me`, `logout`).
- Panel admin protegido por `auth:sanctum` + middleware `admin`.
- CRUD de productos con subida de imagen (`multipart/form-data`).
- Catalogo publico con paginacion (10 items por vista).
- Ruta dinamica de detalle de producto.
- Carrito con Pinia, totales reactivos y persistencia en localStorage.
- Mensajes de exito/error y estados de carga.

## Usuario admin de prueba
- Correo: `admin@tienda.com`
- Password: `Admin1234`

## Ejecucion rapida
1. Configurar y levantar backend (ver `backend/README.md`).
2. Configurar y levantar frontend (ver `frontend/README.md`).
3. Abrir `http://127.0.0.1:5173`.
