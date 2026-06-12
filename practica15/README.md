# Practica 15 - Despliegue en Produccion

Alumno: Alejandro Avalos Espinosa

Esta carpeta agrupa los artefactos de despliegue para llevar la aplicacion a un entorno de produccion.

## Contenido
- `backend/.env.production.example`
- `frontend/.env.production.example`
- `infra/nginx/tienda.conf`
- `infra/supervisor/tienda.conf`
- `.github/workflows/deploy.yml`
- `evidencias/Reporte_Practica_15_Despliegue_Produccion.docx`

## Flujo resumido
1. Preparar el servidor Ubuntu con Nginx, PHP-FPM, MySQL, Redis, Node.js, Composer y Supervisor.
2. Configurar variables de entorno de produccion para Laravel y Vue.
3. Compilar el frontend con `npm run build`.
4. Publicar la SPA con Nginx y dejar Laravel detras de PHP-FPM.
5. Mantener el worker de colas con Supervisor.
6. Automatizar el despliegue con GitHub Actions.
