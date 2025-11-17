<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'task_id', 'start_time', 'end_time', 
        'duration_minutes', 'description'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Calculate duration automatically
    public function calculateDuration()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->diffInMinutes($this->end_time);
        }
        return null;
    }
}