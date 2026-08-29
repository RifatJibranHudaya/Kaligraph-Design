<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $table = 'home_content';

    protected $fillable = [
        'section', 'title', 'subtitle', 'content', 'icon',
        'order_index', 'is_active', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'order_index' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
