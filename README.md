# Laravel Inventory Management System

A comprehensive inventory management system built with Laravel 10+ featuring real-time stock tracking, request processing, vendor management, and PDF document generation.

## Features

### Core Functionality
- **User Authentication**: Session-based login system with seeded users
- **Category Management**: Organize items by categories with full CRUD operations
- **Item Type Management**: Manage inventory items with stock integration
- **Real-time Stock Tracking**: Live stock availability checking with color-coded status
- **Request Processing**: Complete request workflow with automatic stock allocation
- **Purchase Order Management**: Vendor procurement with PO generation
- **Document Generation**: Professional PDF documents (Nota Dinas, BAPBJ)
- **Stock Movement Tracking**: Complete audit trail of all stock changes

### Technical Features
- **Responsive Design**: Tailwind CSS with Alpine.js for interactive components
- **PDF Generation**: Professional Indonesian government document templates
- **Export Functionality**: CSV exports for stock reports and movements
- **Search & Filtering**: Advanced filtering across all listing pages
- **Pagination**: Efficient handling of large datasets
- **Real-time Alerts**: Low stock notifications and status updates

## Database Structure

The system uses 11 core tables with proper relationships:

1. **users** - System users with role-based access
2. **categories** - Item categorization
3. **item_types** - Individual inventory items
4. **vendors** - Supplier information
5. **requests** - Internal item requests
6. **request_items** - Individual items within requests
7. **inventory_stock** - Current stock levels
8. **stock_movements** - Complete movement history
9. **purchase_orders** - Vendor purchase orders
10. **purchase_order_items** - Items within purchase orders
11. **generated_documents** - PDF document tracking

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL (XAMPP recommended)

### Setup Instructions

1. **Clone or setup the project**
   ```bash
   cd inventory-management-system
   ```

2. **Run the setup script (Linux/Mac)**
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

3. **Manual setup (Windows or alternative)**
   ```bash
   # Install dependencies
   composer install
   npm install

   # Setup environment
   cp .env.example .env
   php artisan key:generate

   # Create database 'inventory_management' in MySQL
   # Update .env with your database credentials

   # Run migrations and seeders
   php artisan migrate
   php artisan db:seed

   # Build assets
   npm run build

   # Create storage directories
   mkdir -p storage/app/documents/nota-dinas
   mkdir -p storage/app/documents/bapbj
   ```

4. **Start the application**
   ```bash
   php artisan serve
   ```

5. **Access the system**
   - URL: http://localhost:8000
   - Default login: `admin` / `admin123`

## Default User Accounts

| Username | Password | Description |
|----------|----------|-------------|
| admin | admin123 | System administrator |
| warehouse | warehouse123 | Warehouse staff |
| procurement | procurement123 | Procurement staff |

## System Modules

### 1. Dashboard
- Real-time statistics and metrics
- Recent requests overview
- Low stock alerts
- Quick action buttons
- Stock movement history

### 2. Inventory Management
- **Categories**: Organize items (ATK, Electronics, Furniture, etc.)
- **Item Types**: 40+ pre-seeded items with realistic data
- **Stock Tracking**: Real-time availability with min stock alerts
- **Stock Adjustments**: Manual stock updates with audit trail

### 3. Request Management
- **Create Requests**: Multi-item requests with real-time stock checking
- **Process Requests**: Automatic stock allocation and fulfillment
- **Status Tracking**: Draft → Submitted → Completed workflow
- **Partial Fulfillment**: Handle cases where full quantity isn't available

### 4. Warehouse Operations
- **Stock Overview**: Current inventory with search/filtering
- **Stock Adjustments**: In/Out/Adjustment operations
- **Movement History**: Complete audit trail
- **Low Stock Alerts**: Automated notifications
- **Export Reports**: CSV exports for analysis

### 5. Procurement
- **Vendor Management**: Complete vendor database
- **Purchase Orders**: PO creation and management
- **Order Tracking**: Draft → Sent → Completed workflow
- **Integration**: Links to request fulfillment needs

### 6. Document Generation
- **Nota Dinas Internal**: Professional internal memos
- **BAPBJ**: Goods receipt documentation
- **Auto-numbering**: Sequential document numbering
- **PDF Storage**: Organized file management
- **Download/Archive**: Complete document history

## Sample Data

The system includes comprehensive sample data:
- **8 Categories** (ATK, Electronics, Furniture, etc.)
- **40+ Item Types** with realistic Indonesian office supplies
- **6 Vendors** with complete contact information
- **15 Sample Requests** with various statuses
- **10 Purchase Orders** demonstrating procurement flow
- **Realistic Stock Levels** including low-stock scenarios

---

**System Status**: Production Ready ✅
**Last Updated**: January 2024
**Version**: 1.0.0
