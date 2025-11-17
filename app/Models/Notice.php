<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'priority', 'start_date', 'end_date', 'is_active', 'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope for active notices
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for current notices (within date range)
    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where(function($q) {
                        $q->where('end_date', '>=', now())
                          ->orWhereNull('end_date');
                    });
    }

    // Check if notice is currently active
    public function getIsCurrentlyActiveAttribute()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date > now()) {
            return false;
        }

        if ($this->end_date && $this->end_date < now()) {
            return false;
        }

        return true;
    }
}