#!/bin/sh
set -e

echo "🚀 Starting Ventuz Store..."

# ── 1. Create necessary storage directories ──────────────────
echo "📁 Ensuring storage directories exist..."
mkdir -p /var/www/html/storage/app/public/proofs
mkdir -p /var/www/html/storage/app/public/banners
mkdir -p /var/www/html/storage/app/public/games
mkdir -p /var/www/html/storage/app/public/articles
mkdir -p /var/www/html/storage/app/public/payments
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views

# Fix storage & cache permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ── 2. Wait for PostgreSQL to be reachable ──────────────────
echo "⏳ Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT}..."
until php -r "new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    echo "   ...not ready yet, retrying in 3s"
    sleep 3
done
echo "✅ PostgreSQL is reachable!"

# ── 3. Run package discovery & migrations ───────────────────
echo "🔍 Discovering packages..."
php /var/www/html/artisan package:discover --ansi 2>/dev/null || true

echo "🔄 Running migrations..."
php /var/www/html/artisan migrate --force --no-interaction

# ── 4. Create storage symlink ────────────────────────────────
echo "🔗 Linking storage..."
php /var/www/html/artisan storage:link --force 2>/dev/null || true

# ── 5. Clear & warm up caches ───────────────────────────────
echo "⚡ Warming up caches..."
php artisan optimize:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "✅ Bootstrap complete — launching Supervisor..."

# ── 6. Start Supervisor (manages Octane + Reverb + Queue + Scheduler) ──
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
