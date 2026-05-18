@echo off
REM CerdasFin Quick Start Script for Windows

echo.
echo 🚀 CerdasFin - Platform Literasi Keuangan
echo ========================================

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: artisan file not found. Please run this script from the project root directory.
    exit /b 1
)

echo 📦 Installing PHP dependencies...
call composer install

echo 🔑 Generating application key...
php artisan key:generate

echo 🗄️ Running database migrations...
php artisan migrate --force

echo 🌱 Seeding database with sample data...
php artisan db:seed --force

echo 🎨 Installing Node dependencies...
call npm install

echo 📦 Building CSS assets...
call npm run build

echo 🧹 Clearing caches...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo.
echo ✅ Setup complete!
echo.
echo 📝 Test Account:
echo    Email: john@example.com
echo    Password: password
echo.
echo 🌐 Start the development server with:
echo    php artisan serve
echo.
echo 📦 In another terminal, run:
echo    npm run dev
echo.
echo Then open http://localhost:8000 in your browser
echo.
pause
