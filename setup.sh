#!/bin/bash

echo "🚀 Setting up Laravel Inventory Management System..."

# Check if .env exists, if not copy from .env.example
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Created .env file"
else
    echo "✅ .env file already exists"
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Create database (MySQL)
echo "🗄️  Please ensure your MySQL server is running and create a database named 'inventory_management'"
echo "   For XAMPP users: Open phpMyAdmin and create the database"

# Run migrations
echo "📊 Running database migrations..."
php artisan migrate

# Seed the database
echo "🌱 Seeding database with sample data..."
php artisan db:seed

# Create storage directories
echo "📁 Creating storage directories..."
mkdir -p storage/app/documents/nota-dinas
mkdir -p storage/app/documents/bapbj
mkdir -p storage/app/documents/purchase-orders

# Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "To start the application:"
echo "1. Make sure your MySQL server is running (XAMPP users: start MySQL in XAMPP Control Panel)"
echo "2. Run: php artisan serve"
echo "3. Open: http://localhost:8000"
echo ""
echo "Default login credentials:"
echo "Username: admin"
echo "Password: admin123"
echo ""
echo "Other test accounts:"
echo "Username: warehouse, Password: warehouse123"
echo "Username: procurement, Password: procurement123"