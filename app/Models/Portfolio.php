<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nama',
        'foto',
        'deskripsi',
        'client',
        'lokasi',
        'tahun',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    // ─── Relationships ───────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    // ─── Accessors ───────────────────────────────────────────

    /**
     * Get portfolio photo URL or fallback.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        // Check new Storage path first
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists('portfolios/' . $this->foto)) {
            return asset('storage/portfolios/' . $this->foto);
        }

        // Fallback to legacy public path
        if (file_exists(public_path('uploads/portfolios/' . $this->foto))) {
            return asset('uploads/portfolios/' . $this->foto);
        }

        return null;
    }
}
