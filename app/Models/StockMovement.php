<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type_id',
        'movement_type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference',
        'notes',
        'created_by',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}