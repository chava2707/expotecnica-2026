# Despliegue con Docker

Todo el sistema (aplicación, worker de correos y MySQL) se ejecuta en contenedores. En la
máquina destino solo se necesita **Docker Desktop** y un navegador: no hace falta instalar
PHP, MySQL, Composer ni Node.

## Servicios

| Servicio | Imagen | Función |
| :-- | :-- | :-- |
| `app` | build local (PHP 8.4 + Apache) | Sirve la aplicación en el puerto 8000 |
| `worker` | misma imagen | Procesa la cola `emails` |
| `mysql` | `mysql:8.0` | Base de datos con volumen persistente |

Los archivos subidos y los logs viven en volúmenes de Docker, así que sobreviven a reinicios.

## Primer despliegue

```bash
# 1. Copiar el proyecto a la máquina destino
git clone https://github.com/chava2707/expotecnica-2026.git
cd expotecnica-2026

# 2. Crear el archivo de entorno
cp .env.example .env          # Windows: copy .env.example .env

# 3. Editar .env (ver sección siguiente)

# 4. Construir y levantar
docker compose up -d --build

# 5. Datos iniciales (solo la primera vez)
docker compose exec app php artisan db:seed --force
```

Abrir http://localhost:8000. La `APP_KEY` se genera automáticamente en el primer arranque y se
guarda en el volumen de `storage`, así que no cambia entre reinicios.

## Variables importantes

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_DATABASE=expo
DB_USERNAME=expo
DB_PASSWORD=una-clave-fuerte
DB_ROOT_PASSWORD=otra-clave-fuerte

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_FROM_ADDRESS=tu-correo@gmail.com
MAIL_ENCRYPTION=tls
```

> En Docker el host de la base de datos siempre es `mysql`, nunca `127.0.0.1`.

Si usas un dominio con subdominios, ajusta `SESSION_DOMAIN` (por ejemplo `.midominio.com`).

## Operación

```bash
docker compose ps                    # estado de los servicios
docker compose logs -f worker        # ver el envío de correos
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize:clear
docker compose up -d --build         # recompilar tras cambios de código
docker compose down                  # detener (los datos se conservan)
```

## Respaldos

```bash
# Base de datos
docker compose exec mysql sh -c 'exec mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" expo' > respaldo.sql

# Restaurar
docker compose exec -T mysql sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD" expo' < respaldo.sql
```

Respalda también el volumen `uploads_data`, que contiene los PDFs e imágenes de los proyectos.

## Problemas comunes

| Síntoma | Causa / solución |
| :-- | :-- |
| El puerto 8000 está en uso | Cambia `"8000:80"` por `"8001:80"` en `docker-compose.yml` |
| Carga sin estilos | El build del frontend falló: `docker compose up -d --build` |
| Error de conexión a MySQL al inicio | MySQL tarda en estar listo; espera y revisa `docker compose ps` |
| No llegan los correos | Revisa `docker compose logs -f worker` y las variables `MAIL_*` |
| Error 500 tras cambiar código | `docker compose exec app php artisan optimize:clear` |
