<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\StockMovementController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// All routes are now public
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Item Types
    Route::resource('item-types', ItemTypeController::class);
    Route::get('/api/item-types/check-stock', [ItemTypeController::class, 'checkStock'])->name('item-types.check-stock');

    // Requests
    Route::resource('requests', RequestController::class);
    Route::patch('requests/{request}/submit', [RequestController::class, 'submit'])->name('requests.submit');

    // Warehouse Management
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/warehouse/adjust-stock', [WarehouseController::class, 'adjustStock'])->name('warehouse.adjust-stock');
    Route::post('/warehouse/update-stock', [WarehouseController::class, 'updateStock'])->name('warehouse.update-stock');
    Route::get('/warehouse/movements', [WarehouseController::class, 'movements'])->name('warehouse.movements');
    Route::get('/warehouse/low-stock', [WarehouseController::class, 'lowStock'])->name('warehouse.low-stock');
    Route::get('/warehouse/export', [WarehouseController::class, 'export'])->name('warehouse.export');

    // Stock Movements
    Route::resource('stock-movements', StockMovementController::class)->only(['index', 'show']);
    Route::get('/stock-movements/export', [StockMovementController::class, 'export'])->name('stock-movements.export');

    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/nota-dinas/generate', [DocumentController::class, 'generateNotaDinas'])->name('documents.nota-dinas.generate');
    Route::post('/documents/nota-dinas/create', [DocumentController::class, 'createNotaDinas'])->name('documents.nota-dinas.create');
    Route::get('/documents/bapbj/generate', [DocumentController::class, 'generateBapbj'])->name('documents.bapbj.generate');
    Route::post('/documents/bapbj/create', [DocumentController::class, 'createBapbj'])->name('documents.bapbj.create');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Procurement - Vendors
    Route::get('/procurement/vendors', [ProcurementController::class, 'vendors'])->name('procurement.vendors');
    Route::get('/procurement/vendors/create', [ProcurementController::class, 'createVendor'])->name('procurement.vendors.create');
    Route::post('/procurement/vendors', [ProcurementController::class, 'storeVendor'])->name('procurement.vendors.store');
    Route::get('/procurement/vendors/{vendor}', [ProcurementController::class, 'showVendor'])->name('procurement.vendors.show');
    Route::get('/procurement/vendors/{vendor}/edit', [ProcurementController::class, 'editVendor'])->name('procurement.vendors.edit');
    Route::patch('/procurement/vendors/{vendor}', [ProcurementController::class, 'updateVendor'])->name('procurement.vendors.update');
    Route::delete('/procurement/vendors/{vendor}', [ProcurementController::class, 'destroyVendor'])->name('procurement.vendors.destroy');

    // Procurement - Purchase Orders
    Route::get('/procurement/purchase-orders', [ProcurementController::class, 'purchaseOrders'])->name('procurement.purchase-orders');
    Route::get('/procurement/purchase-orders/create', [ProcurementController::class, 'createPurchaseOrder'])->name('procurement.purchase-orders.create');
    Route::post('/procurement/purchase-orders', [ProcurementController::class, 'storePurchaseOrder'])->name('procurement.purchase-orders.store');
    Route::get('/procurement/purchase-orders/{purchaseOrder}', [ProcurementController::class, 'showPurchaseOrder'])->name('procurement.purchase-orders.show');
    Route::get('/procurement/purchase-orders/{purchaseOrder}/edit', [ProcurementController::class, 'editPurchaseOrder'])->name('procurement.purchase-orders.edit');
    Route::patch('/procurement/purchase-orders/{purchaseOrder}', [ProcurementController::class, 'updatePurchaseOrder'])->name('procurement.purchase-orders.update');
    Route::patch('/procurement/purchase-orders/{purchaseOrder}/send', [ProcurementController::class, 'sendPurchaseOrder'])->name('procurement.purchase-orders.send');
    Route::patch('/procurement/purchase-orders/{purchaseOrder}/complete', [ProcurementController::class, 'completePurchaseOrder'])->name('procurement.purchase-orders.complete');
    Route::delete('/procurement/purchase-orders/{purchaseOrder}', [ProcurementController::class, 'destroyPurchaseOrder'])->name('procurement.purchase-orders.destroy');
