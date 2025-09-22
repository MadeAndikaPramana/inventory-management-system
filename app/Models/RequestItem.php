<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'item_type_id',
        'qty_requested',
        'qty_fulfilled',
        'status',
        'notes',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function getRemainingQtyAttribute()
    {
        return $this->qty_requested - $this->qty_fulfilled;
    }

    public function getIsFulfilledAttribute()
    {
        return $this->qty_fulfilled >= $this->qty_requested;
    }
}