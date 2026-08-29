<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operational extends Model
{
    use HasFactory;

    protected $table = 'operational';

    protected $fillable = [
        'user_id', 'nama_alat', 'harga', 'tempat_beli',
        'merk', 'periode_ganti', 'tanggal_beli', 'keterangan',
    ];

    protected $casts = [
        'tanggal_beli'   => 'date',
        'harga'          => 'integer',
        'periode_ganti'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
