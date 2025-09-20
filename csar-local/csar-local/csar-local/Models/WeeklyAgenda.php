<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyAgenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_type', // 'meeting', 'delivery', 'visit', 'task', 'instruction'
        'start_date',
        'end_date',
        'location',
        'participants',
        'assigned_to',
        'created_by',
        'priority',
        'status', // 'scheduled', 'in_progress', 'completed', 'cancelled'
        'notes',
        'attachments',
        'reminder_sent',
        'category',
        'tags'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'participants' => 'array',
        'attachments' => 'array',
        'tags' => 'array',
        'reminder_sent' => 'boolean',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeThisWeek($query)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        return $query->whereBetween('start_date', [$startOfWeek, $endOfWeek]);
    }

    public function scopeNextWeek($query)
    {
        $startOfNextWeek = now()->addWeek()->startOfWeek();
        $endOfNextWeek = now()->addWeek()->endOfWeek();
        return $query->whereBetween('start_date', [$startOfNextWeek, $endOfNextWeek]);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
 
 
 
 
 
 