# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview
This is a comprehensive Laravel 10+ inventory management system with the following key components:
- User authentication with session-based login
- Category and item type management
- Request processing and fulfillment workflow
- Real-time stock tracking and management
- Purchase order generation and vendor management
- PDF document generation (Nota Dinas, BAPBJ)
- Responsive Tailwind CSS frontend with Alpine.js

## Common Development Commands

### Setup and Migration
```bash
# Install dependencies
composer install
npm install

# Setup database
php artisan migrate
php artisan db:seed

# Development server
php artisan serve
npm run dev
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name --create=table_name
```

### Model and Controller Generation
```bash
# Create model with migration
php artisan make:model ModelName -m

# Create controller with resources
php artisan make:controller ControllerName --resource

# Create request validation
php artisan make:request RequestName
```

## High-Level Architecture

### Database Structure
The system uses 11 core tables with the following key relationships:
- `users` → `requests`, `stock_movements`, `purchase_orders` (one-to-many)
- `categories` → `item_types` (one-to-many)
- `item_types` → `inventory_stock` (one-to-one), related to `request_items`, `stock_movements` (one-to-many)
- `requests` → `request_items` (one-to-many)
- `vendors` → `purchase_orders` (one-to-many)
- `purchase_orders` → `purchase_order_items` (one-to-many)

### Key Business Logic Components

#### Stock Management Flow
1. **Request Creation**: Users create requests with item requirements
2. **Stock Availability Check**: Real-time validation against current inventory
3. **Request Processing**: Auto-allocation of available stock, creation of stock movements
4. **Purchase Order Generation**: For items requiring vendor procurement
5. **Document Generation**: PDF creation for internal and external communications

#### Core Models with Business Logic
- `ItemType`: Includes stock checking methods (`getCurrentStockAttribute`, `isLowStock`)
- `Request`: Fulfillment tracking (`getTotalItemsAttribute`, `getIsFullyFulfilledAttribute`)
- `RequestItem`: Individual item processing (`getRemainingQtyAttribute`, `getIsFulfilledAttribute`)
- `InventoryStock`: Current stock tracking with low-stock alerts

### Authentication System
- Simple username/password authentication (no registration)
- Session-based auth with custom login logic
- Default admin user: username=admin, password=admin123
- Auth middleware protects all routes except login

### Frontend Architecture
- **Layout**: `resources/views/layouts/app.blade.php` - Main layout with sidebar navigation
- **Components**: Tailwind CSS for styling, Alpine.js for interactive elements
- **Real-time Features**: Stock availability checking, form validation, dynamic content updates

### PDF Generation
- **Library**: dompdf for PDF creation
- **Templates**: Professional Indonesian government document formats
- **Document Types**: Nota Dinas Internal, BAPBJ (Berita Acara Penerimaan Barang)
- **Storage**: Documents saved in `storage/app/documents/` with database tracking

### Key Controllers and Their Responsibilities
- `AuthController`: Login/logout functionality
- `DashboardController`: Main dashboard with statistics and alerts
- `RequestController`: Request lifecycle management with stock integration
- `WarehouseController`: Stock management and manual adjustments
- `DocumentController`: PDF generation and document history
- `ProcurementController`: Vendor and purchase order management

### Configuration Notes
- Database: MySQL configured in `.env` (database: inventory_management)
- File Storage: Documents stored in `storage/app/documents/` subdirectories
- PDF Generation: DomPDF configured for Indonesian document formats
- Excel Export: Maatwebsite/Excel for stock reports and data export

### Development Workflow
1. Model changes require corresponding migration updates
2. All stock changes must create `StockMovement` records for audit trail
3. Request processing involves multiple table updates (requests, request_items, inventory_stock, stock_movements)
4. Document generation creates database records in `generated_documents` table
5. All user actions require authentication and are logged with user IDs

### Testing Approach
- Feature tests focus on request processing workflow
- Unit tests for stock calculation methods
- Authentication testing for protected routes
- PDF generation testing for document integrity