#!/bin/sh
set -e

cd /var/www/html

# Directorios obligatorios de Laravel (pueden faltar en el volumen montado)
mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/testing

# Permisos correctos sobre los volumenes montados (primera vez)
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Generar la llave APP_KEY una sola vez y guardarla en el volumen de storage,
# asi no cambia (y no se cierran sesiones) al reiniciar el contenedor.
if [ ! -f storage/app/.app_key ]; then
    php -r 'file_put_contents("storage/app/.app_key", "base64:" . base64_encode(random_bytes(32)) . PHP_EOL);'
fi
export APP_KEY="$(cat storage/app/.app_key)"

# Enlace public/storage -> storage/app/public (imagenes y PDFs de proyectos)
php artisan storage:link --force

# Crear/actualizar las tablas (solo el contenedor app; el worker solo procesa la cola)
if [ "${QUEUE_WORKER:-false}" != "true" ]; then
    php artisan migrate --force
fi

exec "$@"
