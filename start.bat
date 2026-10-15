@echo off
title Tanaman Hias - Laravel Server

echo ============================================
echo   Sistem Informasi Penjualan Tanaman Hias
echo ============================================
echo.

set PATH=C:\laragon\bin\php\php-8.5.4-Win32-vs17-x64;C:\laragon\bin\nodejs\node-v24.14.1-win-x64;C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin;%PATH%

echo [INFO] PHP Version:
php -v | findstr /i "PHP 8"
echo.
echo [INFO] Node Version:
node -v
echo.

echo [1/2] Menjalankan Vite (background)...
start "Vite Dev Server" cmd /c "npm run dev"

echo [2/2] Menjalankan Laravel Server...
echo.
echo   Buka browser: http://localhost:8000
echo   Tekan Ctrl+C untuk stop server
echo.

php artisan serve
