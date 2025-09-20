<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'type',
        'status',
        'full_name',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'region',
        'description',
        'admin_comment',
        'assigned_to',
        'request_date',
        'processed_date',
        'sms_sent',
        'is_viewed',
        'viewed_at'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'request_date' => 'date',
        'processed_date' => 'date',
        'sms_sent' => 'boolean',
        'is_viewed' => 'boolean',
        'viewed_at' => 'datetime'
    ];

    /**
     * Marquer la demande comme vue si ce n'est pas déjà fait
     */
    public function markAsViewed(): void
    {
        if (!$this->is_viewed) {
            $this->forceFill([
                'is_viewed' => true,
                'viewed_at' => now(),
            ])->save();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public static function generateTrackingCode()
    {
        do {
            $code = 'CSAR-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'completed' => 'blue',
            default => 'gray'
        };
    }
} 