<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calculate total cart value from items.
     */
    public function getTotalAttribute(): int
    {
        return (int) $this->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });
    }

    /**
     * Total number of items in cart.
     */
    public function getItemCountAttribute(): int
    {
        return (int) $this->items->sum('quantity');
    }
}
