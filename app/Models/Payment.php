<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'jumlah',
        'metode',
        'bukti',
        'keterangan',
        'tanggal_bayar',
    ];

    protected $casts = [
        'jumlah'        => 'integer',
        'tanggal_bayar' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get payment proof URL or null.
     */
    public function getBuktiUrlAttribute(): ?string
    {
        if ($this->bukti && file_exists(public_path('uploads/payments/' . $this->bukti))) {
            return asset('uploads/payments/' . $this->bukti);
        }
        return null;
    }

    /**
     * Formatted amount display.
     */
    public function getJumlahDisplayAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}
