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

# Path PHP 8.3 di aaPanel
PHP_BIN="/www/server/php/83/bin/php"
# Jika composer di-install secara global, kita bisa memanggilnya dengan PHP_BIN
# atau asumsikan composer bisa dipanggil langsung, tapi lebih aman dilewatkan via php jika berbentuk phar
# Namun umumnya di aaPanel kita cukup pastikan PHP yang dieksekusi adalah 8.3

echo "$LOG_PREFIX 📦 Memperbarui paket PHP (composer install)..."
$PHP_BIN /usr/bin/composer install --no-dev --optimize-autoloader --no-interaction 2>&1 || composer install --no-dev --optimize-autoloader --no-interaction 2>&1

echo "$LOG_PREFIX 🗄️ Menjalankan migrasi database..."
$PHP_BIN artisan migrate --force 2>&1

echo "$LOG_PREFIX 🧹 Membersihkan dan mengoptimasi cache sistem..."
$PHP_BIN artisan optimize:clear 2>&1
$PHP_BIN artisan config:clear 2>&1
$PHP_BIN artisan view:clear 2>&1
$PHP_BIN artisan route:clear 2>&1
$PHP_BIN artisan optimize 2>&1

echo "$LOG_PREFIX ⚡ Membangun cache Filament..."
$PHP_BIN artisan filament:optimize 2>&1 || true
$PHP_BIN artisan icons:cache 2>&1 || true

echo "$LOG_PREFIX ✅ DEPLOYMENT SELESAI SUKSES!"
