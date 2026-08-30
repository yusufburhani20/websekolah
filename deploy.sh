#!/bin/bash
# ===================================================
# WEBSITE SMK FADRIS - Auto Deployment Script aaPanel
# ===================================================

LOG_PREFIX="[$(date '+%H:%M:%S')]"
APP_DIR="$(cd "$(dirname "$0")" && pwd)"

# Nonaktifkan interaksi terminal untuk semua perintah git agar tidak stuck
export GIT_TERMINAL_PROMPT=0
export GIT_ASKPASS=echo
export SSH_ASKPASS=echo

echo "$LOG_PREFIX 🚀 Memulai proses deployment Website SMK FADRIS..."

cd "$APP_DIR" || exit 1

echo "$LOG_PREFIX 📥 Menarik kode terbaru dari GitHub..."
git checkout -- . 2>/dev/null || true
git clean -fd 2>/dev/null || true

# Karena dieksekusi dari PHP, kita pakai git pull biasa (asumsi repo publik atau SSH sudah diset di user www/root)
git pull origin main 2>&1

echo "$LOG_PREFIX 📦 Memperbarui paket PHP (composer install)..."
composer install --no-dev --optimize-autoloader --no-interaction 2>&1

echo "$LOG_PREFIX 🗄️ Menjalankan migrasi database..."
php artisan migrate --force 2>&1

echo "$LOG_PREFIX 🧹 Membersihkan dan mengoptimasi cache sistem..."
php artisan optimize:clear 2>&1
php artisan optimize 2>&1

echo "$LOG_PREFIX ⚡ Membangun cache Filament..."
php artisan filament:optimize 2>&1 || true

echo "$LOG_PREFIX ✅ DEPLOYMENT SELESAI SUKSES!"
