<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'requestor_name',
        'department',
        'request_date',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTotalItemsAttribute()
    {
        return $this->requestItems->sum('qty_requested');
    }

    public function getFulfilledItemsAttribute()
    {
        return $this->requestItems->sum('qty_fulfilled');
    }

    public function getIsFullyFulfilledAttribute()
    {
        return $this->getTotalItemsAttribute() === $this->getFulfilledItemsAttribute();
    }
}