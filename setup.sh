#!/bin/bash
# CerdasFin Quick Start Script

echo "🚀 CerdasFin - Platform Literasi Keuangan"
echo "========================================"

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this script from the project root directory."
    exit 1
fi

echo "📦 Installing dependencies..."
composer install

echo "🔑 Generating application key..."
php artisan key:generate

echo "🗄️  Running database migrations..."
php artisan migrate --force

echo "🌱 Seeding database with sample data..."
php artisan db:seed --force

echo "🎨 Building CSS assets..."
npm install
npm run build

echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo ""
echo "✅ Setup complete!"
echo ""
echo "📝 Test Account:"
echo "   Email: john@example.com"
echo "   Password: password"
echo ""
echo "🌐 Start the development server with:"
echo "   php artisan serve"
echo ""
echo "📦 In another terminal, run:"
echo "   npm run dev"
echo ""
echo "Then open http://localhost:8000 in your browser"
