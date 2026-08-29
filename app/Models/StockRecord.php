<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRecord extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'branch_id', 'tanggal', 'tipe', 'produk', 'jumlah', 'satuan'];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
