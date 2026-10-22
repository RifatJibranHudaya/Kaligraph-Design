<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'integer',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Line total = unit_price × quantity (calculated server-side).
     */
    public function getSubtotalAttribute(): int
    {
        return (int) ($this->unit_price * $this->quantity);
    }
}
