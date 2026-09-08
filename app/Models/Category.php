<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'foto',
        'emoji',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /**
     * Auto-generate slug from nama on create/update.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nama);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('nama') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->nama);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    /**
     * Get category photo URL or fallback.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && file_exists(public_path('uploads/categories/' . $this->foto))) {
            return asset('uploads/categories/' . $this->foto);
        }
        return null;
    }
}
