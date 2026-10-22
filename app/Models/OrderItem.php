<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'produk', 'harga', 'quantity', 'unit_price'];

    protected $casts = [
        'harga'      => 'integer',
        'unit_price' => 'integer',
        'quantity'   => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Line total = unit_price × quantity (server-side calculation).
     */
    public function getSubtotalAttribute(): int
    {
        return (int) ($this->unit_price * $this->quantity);
    }
}
