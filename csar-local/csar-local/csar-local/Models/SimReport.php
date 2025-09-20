<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'report_date',
        'period',
        'summary',
        'context_objectives',
        'supply_level',
        'price_analysis',
        'regional_distribution',
        'key_trends',
        'recommendations',
        'annexes',
        'methodology',
        'status',
        'is_published',
        'published_at',
        'created_by',
        'document_file',
        'cover_image'
    ];

    protected $casts = [
        'report_date' => 'date',
        'supply_level' => 'array',
        'price_analysis' => 'array',
        'regional_distribution' => 'array',
        'key_trends' => 'array',
        'recommendations' => 'array',
        'annexes' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('report_date', 'desc');
    }
} 
 
 
 
 
 
 