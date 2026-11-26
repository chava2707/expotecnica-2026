# Instalación local (sin Docker)

Guía para correr el sistema en tu máquina con PHP, MySQL y Node instalados directamente.

## Requisitos

| Software | Versión mínima |
| :-- | :-- |
| PHP | 8.3 |
| Composer | 2.x |
| MySQL | 5.7 (recomendado 8.0) |
| Node.js | 20 |
| Git | opcional |

Extensiones de PHP necesarias (verifica con `php -m`):

```
pdo_mysql  mbstring  openssl  fileinfo  gd  zip  xml  ctype  tokenizer  curl  bcmath
```

## Pasos

```bash
# 1. Clonar
git clone https://github.com/chava2707/expotecnica-2026.git
cd expotecnica-2026

# 2. Dependencias de PHP
composer install

# 3. Archivo de entorno
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate

# 4. Base de datos
#    Crea la base "expo" en MySQL y ajusta en .env:
#      DB_HOST=127.0.0.1
#      DB_DATABASE=expo
#      DB_USERNAME=root
#      DB_PASSWORD=
php artisan migrate --seed

# 5. Archivos públicos (imágenes y PDFs)
php artisan storage:link

# 6. Frontend
npm install
npm run build
```

## Ejecutar

**Opción A — todo en una terminal**

```bash
composer dev
```

Levanta el servidor, el worker de la cola, los logs y Vite a la vez.

**Opción B — manual**

```bash
php artisan serve            # terminal 1 → http://127.0.0.1:8000
php artisan queue:work --queue=emails --sleep=3   # terminal 2
npm run dev                  # terminal 3, solo si editas vistas/CSS
```

## Correo

Los correos (cuenta creada, evaluación completada) se **encolan** en la tabla `jobs`. Sin un
worker corriendo no se envían, aunque la aplicación funcione normal.

Para Gmail necesitas una **contraseña de aplicación**
(https://myaccount.google.com/apppasswords), no tu contraseña normal:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_FROM_ADDRESS=tu-correo@gmail.com
MAIL_ENCRYPTION=tls
```

En desarrollo puedes usar `MAIL_MAILER=log` para escribir los correos en
`storage/logs/laravel.log` sin enviarlos.

## Usuarios de prueba

Tras `php artisan db:seed` (solo desarrollo):

| Rol | Correo | Contraseña |
| :-- | :-- | :-- |
| Administrador | `admin@test.com` | `password` |
| Jueces | `juez1@test.com` … `juez3@test.com` | `password` |
| Suplentes | `suplente1@test.com` … | `password` |
| Estudiantes | `estudiante1@test.com` … | `password` |

> En producción, cada usuario recibe su contraseña inicial y debe cambiarla.

## Comandos útiles

```bash
php artisan optimize:clear      # limpiar caché de config, rutas y vistas
php artisan queue:failed        # ver trabajos fallidos
php artisan queue:retry all     # reintentarlos
php artisan test                # pruebas
vendor/bin/pint                 # formato de código
```

## Notas para producción

- `APP_ENV=production` y `APP_DEBUG=false`.
- `APP_URL` con el dominio real.
- Worker de la cola como servicio permanente (NSSM en Windows, systemd o supervisor en Linux).
- Ejecutar `npm run build`, nunca `npm run dev`.
- `php artisan config:cache` y `php artisan route:cache`.
