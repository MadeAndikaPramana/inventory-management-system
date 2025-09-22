<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'document_number',
        'file_path',
        'generated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}