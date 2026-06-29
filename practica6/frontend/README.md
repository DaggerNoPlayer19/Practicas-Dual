# Frontend - Practica 06

## Requisitos
- Node.js 20+
- Backend corriendo en `http://127.0.0.1:8000`

## API
- En desarrollo, Vite proxya `/api` hacia `http://127.0.0.1:8000`.
- En produccion, la SPA usa `/api` en el mismo dominio donde se sirve la app.

## Instalacion
1. Entrar a carpeta frontend:
   - `cd frontend`
2. Instalar dependencias:
   - `npm install`
3. Levantar modo desarrollo:
   - `npm run dev -- --host 127.0.0.1 --port 5173`
4. Abrir en navegador:
   - `http://127.0.0.1:5173`

## Produccion
- Para desplegar la SPA, ejecuta `npm run build`.
- El resultado queda en `dist/` y es el que consume Laravel en produccion.

## Flujo recomendado de prueba
1. Ir a `/login`.
2. Iniciar sesion con:
   - `admin@tienda.com`
   - `Admin1234`
3. Ir a `/admin/nuevo` para crear productos con imagen.
4. Ver productos e imagenes en `/catalogo`.
5. Agregar productos al carrito y validar persistencia recargando.

## Funcionalidades destacadas
- Vue Router: rutas publicas, dinamicas, privadas y 404.
- Pinia: `auth` y `carrito`.
- Carrito persistente en `localStorage`.
- Subida de imagen con `FormData` y preview local.
- Placeholder de imagen:
  - `public/img/placeholder.png`
