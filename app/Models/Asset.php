<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'serial_number', 'category', 'description', 'purchase_price',
        'purchase_date', 'status', 'assigned_to', 'assigned_date', 'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'assigned_date' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}