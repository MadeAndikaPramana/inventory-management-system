<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    use HasFactory;

    protected $table = 'inventory_stock';

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = null;

    protected $fillable = [
        'item_type_id',
        'current_stock',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function isLowStock()
    {
        return $this->current_stock <= $this->itemType->min_stock;
    }
}