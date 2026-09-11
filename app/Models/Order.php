<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_ORDER       = 'order';
    const STATUS_ON_PROGRESS = 'on_progress';
    const STATUS_SELESAI     = 'selesai';
    const STATUS_CANCELLED   = 'cancelled';

    const STATUSES = [
        self::STATUS_ORDER       => 'Order',
        self::STATUS_ON_PROGRESS => 'On Progress',
        self::STATUS_SELESAI     => 'Selesai',
        self::STATUS_CANCELLED   => 'Cancelled',
    ];

    protected $fillable = [
        'user_id', 'branch_id', 'kategori', 'total', 'keterangan',
        'status', 'nama_pelanggan', 'no_hp', 'alamat',
    ];

    protected $casts = [
        'total' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Total amount already paid.
     */
    public function getTotalDibayarAttribute(): int
    {
        return (int) $this->payments()->sum('jumlah');
    }

    /**
     * Remaining balance.
     */
    public function getSisaTagihanAttribute(): int
    {
        return max(0, $this->total - $this->total_dibayar);
    }

    /**
     * Status badge color helper.
     */
    public function getStatusBadgeAttribute(): string
    {
        switch ($this->status) {
            case self::STATUS_ORDER:
                return 'badge-primary';
            case self::STATUS_ON_PROGRESS:
                return 'badge-warning';
            case self::STATUS_SELESAI:
                return 'badge-success';
            case self::STATUS_CANCELLED:
                return 'badge-danger';
            default:
                return 'badge-primary';
        }
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return $this->getStatusBadgeAttribute();
    }

    /**
     * Status label for display.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Scope: filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
