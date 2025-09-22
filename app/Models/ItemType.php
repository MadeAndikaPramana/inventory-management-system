<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'unit',
        'min_stock',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventoryStock()
    {
        return $this->hasOne(InventoryStock::class);
    }

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function getCurrentStockAttribute()
    {
        return $this->inventoryStock ? $this->inventoryStock->current_stock : 0;
    }

    public function isLowStock()
    {
        return $this->getCurrentStockAttribute() <= $this->min_stock;
    }
}