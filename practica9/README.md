# Proyecto Integrador - Practica 07

Alumno: Alejandro Avalos Espinosa

Estructura:
- `backend/`: API Laravel 12 con Sanctum, CRUD de productos, imagenes, categorias y filtros avanzados.
- `frontend/`: SPA Vue 3 con Router + Pinia + carrito + busqueda, filtros y paginacion.

## Funcionalidades cubiertas
- Autenticacion con Sanctum (`login`, `register`, `me`, `logout`).
- Panel admin protegido por `auth:sanctum` + middleware `admin`.
- CRUD de productos con subida de imagen (`multipart/form-data`).
- Catalogo publico con paginacion server-side (15 items por vista).
- Busqueda por nombre o descripcion.
- Filtro por categoria y rango de precio.
- Ordenamiento por nombre o precio.
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
