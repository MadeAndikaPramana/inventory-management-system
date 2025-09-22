<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'item_type_id',
        'current_stock',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
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