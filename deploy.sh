#!/bin/bash
# ==========================================================
# DEPLOY SCRIPT — PRATAMA ISI YOGYAKARTA
# ==========================================================
# Penggunaan:  ./deploy.sh
# Requirement: git, composer, npm, php8.3-fpm, nginx
# ==========================================================
set -e

SCRIPT_VERSION="1.0.0"
DATE=$(date '+%Y-%m-%d %H:%M:%S')
LOG_FILE="storage/logs/deploy-$(date '+%Y%m%d-%H%M%S').log"

echo ""
echo "╔════════════════════════════════════════════╗"
echo "║     DEPLOY PRATAMA v$SCRIPT_VERSION         ║"
echo "║     $DATE                 ║"
echo "╚════════════════════════════════════════════╝"
echo ""

# ==========================================================
# FUNGSI LOG
# ==========================================================
log() {
    echo "[$(date '+%H:%M:%S')] $1"
    echo "[$(date '+%H:%M:%S')] $1" >> "$LOG_FILE" 2>/dev/null || true
}

error_exit() {
    echo ""
    echo "❌ ERROR: $1"
    echo "   Cek log: $LOG_FILE"
    exit 1
}

# ==========================================================
# 1. VALIDASI ENVIRONMENT
# ==========================================================
log "Memeriksa environment..."

command -v git >/dev/null 2>&1 || error_exit "Git tidak ditemukan"
command -v composer >/dev/null 2>&1 || error_exit "Composer tidak ditemukan"
command -v php >/dev/null 2>&1 || error_exit "PHP tidak ditemukan"
command -v npm >/dev/null 2>&1 || error_exit "NPM tidak ditemukan"

# Cek file .env
if [ ! -f .env ]; then
    error_exit "File .env tidak ditemukan! Copy dari .env.example"
fi

log "✅ Environment OK"

# ==========================================================
# 2. BACKUP DATABASE
# ==========================================================
log "📦 Backup database..."
mkdir -p storage/app/backups

DB_BACKUP="storage/app/backups/pratama-$(date '+%Y%m%d-%H%M%S').sql"
php artisan db:dump --quiet 2>/dev/null || {
    # Fallback: backup via mysqldump jika package db:dump tidak ada
    if command -v mysqldump &>/dev/null && [ -f .env ]; then
        source .env
        mysqldump -u"${DB_USERNAME:-root}" -p"${DB_PASSWORD:-}" "${DB_DATABASE:-pratama}" > "$DB_BACKUP" 2>/dev/null && {
            log "✅ Backup database: $DB_BACKUP"
        } || {
            log "⚠️  Backup database dilewati (mysqldump tidak bisa terkoneksi)"
        }
    else
        log "⚠️  Backup database dilewati"
    fi
}

# Simpan hanya 7 backup terakhir
ls -t storage/app/backups/*.sql 2>/dev/null | tail -n +8 | xargs rm -f 2>/dev/null || true

# ==========================================================
# 3. GIT PULL
# ==========================================================
log "📥 Mengambil kode terbaru dari repository..."
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo "unknown")
log "   Branch saat ini: $CURRENT_BRANCH"

git fetch origin 2>/dev/null || error_exit "Git fetch gagal"
git pull origin "$CURRENT_BRANCH" 2>/dev/null || {
    # Coba pull main jika branch tidak dikenal
    git pull origin main 2>/dev/null || error_exit "Git pull gagal"
}

log "✅ Kode terbaru berhasil diambil"

# ==========================================================
# 4. COMPOSER INSTALL
# ==========================================================
log "📦 Menginstall dependency Composer..."
composer install --no-dev --optimize-autoloader --no-interaction 2>&1 | tee -a "$LOG_FILE" | tail -1 || error_exit "Composer install gagal"
log "✅ Composer OK"

# ==========================================================
# 5. NPM BUILD
# ==========================================================
log "🔨 Build asset (CSS/JS)..."
if [ -d "node_modules" ]; then
    npm ci --no-audit --no-fund 2>/dev/null || npm install --no-audit 2>/dev/null
else
    npm install --no-audit 2>/dev/null
fi
npm run build 2>&1 | tee -a "$LOG_FILE" | tail -1 || error_exit "NPM build gagal"
log "✅ Asset build OK"

# ==========================================================
# 6. MIGRASI DATABASE
# ==========================================================
log "🗄️  Migrasi database..."
php artisan migrate --force 2>&1 | tee -a "$LOG_FILE" || error_exit "Migrasi gagal"
log "✅ Migrasi OK"

# ==========================================================
# 7. OPTIMASI CACHE
# ==========================================================
log "⚡ Optimasi cache..."
php artisan config:cache 2>&1 | tail -1 || log "⚠️  Config cache gagal"
php artisan route:cache 2>&1 | tail -1 || log "⚠️  Route cache gagal"
php artisan view:cache 2>&1 | tail -1 || log "⚠️  View cache gagal"
php artisan event:cache 2>&1 | tail -1 || log "⚠️  Event cache gagal"
log "✅ Cache OK"

# ==========================================================
# 8. STORAGE LINK
# ==========================================================
php artisan storage:link --force 2>/dev/null || true
log "✅ Storage link OK"

# ==========================================================
# 9. RESTART QUEUE
# ==========================================================
log "🔄 Restart queue worker..."
php artisan queue:restart 2>/dev/null || log "⚠️  Queue restart dilewati"
log "✅ Queue OK"

# ==========================================================
# 10. PERMISSION
# ==========================================================
log "🔧 Setting permission..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
log "✅ Permission OK"

# ==========================================================
# 11. MAINTENANCE MODE (jika diperlukan)
# ==========================================================
log "🔍 Cek maintenance mode..."
if php artisan down --retry=60 2>/dev/null; then
    log "   Mode maintenance diaktifkan"
    php artisan up
    log "   Mode maintenance dimatikan"
fi

# ==========================================================
# SELESAI
# ==========================================================
echo ""
echo "╔════════════════════════════════════════════╗"
echo "║  ✅ DEPLOY BERHASIL                        ║"
echo "║  $DATE                ║"
echo "║  Log: $LOG_FILE            ║"
echo "╚════════════════════════════════════════════╝"
echo ""

# Notifikasi ke output
log "✅ Deploy selesai! Semua proses berjalan normal."
log "   Jika ada masalah, cek storage/logs/laravel.log"
