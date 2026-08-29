<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'production';

    protected $fillable = [
        'user_id', 'branch_id', 'nama_item', 'harga', 'supplier',
        'tempat', 'tanggal', 'keterangan', 'edited_by', 'edited_at',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'edited_at' => 'datetime',
        'harga'     => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
