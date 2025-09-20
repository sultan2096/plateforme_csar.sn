<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'current_price',
        'previous_price',
        'increase_percentage',
        'region',
        'market_name',
        'alert_level', // 'low', 'medium', 'high', 'critical'
        'status', // 'active', 'resolved', 'dismissed'
        'description',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'previous_price' => 'decimal:2',
        'increase_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orWhere('is_active', true);
    }

    public function scopeCritical($query)
    {
        return $query->where('alert_level', 'critical');
    }

    public function scopeHigh($query)
    {
        return $query->where('alert_level', 'high');
    }
} 
 
 
 
 
 
 