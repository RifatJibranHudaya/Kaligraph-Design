<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    const TIPE_CUSTOM_WA = 'custom_wa';
    const TIPE_ECOMMERCE = 'ecommerce';

    protected $fillable = [
        'category_id',
        'nama',
        'sku',
        'tipe_produk',
        'foto',
        'emoji',
        'harga_min',
        'harga_max',
        'harga_default',
        'deskripsi',
        'is_active',
        'stock',
        'urutan',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    protected $casts = [
        'harga_min'     => 'integer',
        'harga_max'     => 'integer',
        'harga_default' => 'integer',
        'is_active'     => 'boolean',
        'stock'         => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function scopeCustomWa($query)
    {
        return $query->where('tipe_produk', self::TIPE_CUSTOM_WA);
    }

    public function scopeEcommerce($query)
    {
        return $query->where('tipe_produk', self::TIPE_ECOMMERCE);
    }

    public function isEcommerce(): bool
    {
        return $this->tipe_produk === self::TIPE_ECOMMERCE;
    }

    public function isCustomWa(): bool
    {
        return $this->tipe_produk !== self::TIPE_ECOMMERCE;
    }

    public function getTipeLabelAttribute(): string
    {
        return $this->isEcommerce() ? 'E-Commerce (Ready Stock)' : 'Pesanan Kustom (WA)';
    }

    /**
     * Check if product is in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Check if product is available for purchase (active + in stock).
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->is_active && $this->stock > 0;
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
     * Get product photo URL — supports both Storage (new) and legacy public paths.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        // Check new Storage path first
        if (Storage::disk('public')->exists('products/' . $this->foto)) {
            return asset('storage/products/' . $this->foto);
        }

        // Fallback to legacy public path
        if (file_exists(public_path('uploads/products/' . $this->foto))) {
            return asset('uploads/products/' . $this->foto);
        }

        return null;
    }

    /**
     * Formatted stock display.
     */
    public function getStockDisplayAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Habis';
        }
        return (string) $this->stock;
    }
}
