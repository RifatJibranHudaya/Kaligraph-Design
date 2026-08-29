<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['nama_cabang', 'alamat', 'map_url', 'map_iframe'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get clean renderable iframe HTML or generate iframe from URL.
     */
    public function getCleanIframeAttribute(): ?string
    {
        if (!empty($this->map_iframe)) {
            $iframe = trim($this->map_iframe);
            // If user pasted a full <iframe ...> tag
            if (str_contains($iframe, '<iframe')) {
                // Ensure responsive width and proper height
                $iframe = preg_replace('/width=["\'][^"\']*["\']/', 'width="100%"', $iframe);
                $iframe = preg_replace('/height=["\'][^"\']*["\']/', 'height="240"', $iframe);
                $iframe = preg_replace('/style=["\'][^"\']*["\']/', 'style="border:0; border-radius:12px; width:100%; height:240px;"', $iframe);
                if (!str_contains($iframe, 'style=')) {
                    $iframe = str_replace('<iframe', '<iframe style="border:0; border-radius:12px; width:100%; height:240px;"', $iframe);
                }
                return $iframe;
            }
            // If user provided an embed URL
            if (str_starts_with($iframe, 'http')) {
                return '<iframe src="' . htmlspecialchars($iframe) . '" width="100%" height="240" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>';
            }
            return $iframe;
        }

        if (!empty($this->map_url) && str_contains($this->map_url, 'google.com/maps')) {
            return '<iframe src="' . htmlspecialchars($this->map_url) . '&output=embed" width="100%" height="240" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>';
        }

        return null;
    }
}
