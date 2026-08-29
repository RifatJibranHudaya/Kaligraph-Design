<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'emoji',
        'harga_min',
        'harga_max',
        'harga_default',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'harga_min'     => 'integer',
        'harga_max'     => 'integer',
        'harga_default' => 'integer',
        'is_active'     => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    /**
     * Formatted price range string.
     * Example: "Rp 350.000 - Rp 500.000" or "Rp 350.000"
     */
    public function getHargaDisplayAttribute(): string
    {
        $min = $this->harga_min ?: $this->harga_default;
        $max = $this->harga_max;

        if ($max && $max > $min) {
            return 'Rp ' . number_format($min, 0, ',', '.') . ' - Rp ' . number_format($max, 0, ',', '.');
        }

        if ($min > 0) {
            return 'Rp ' . number_format($min, 0, ',', '.');
        }

        return 'Hubungi Kami';
    }

    /**
     * Get product photo URL or fallback.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && file_exists(public_path('uploads/products/' . $this->foto))) {
            return asset('uploads/products/' . $this->foto);
        }
        return null;
    }
}
