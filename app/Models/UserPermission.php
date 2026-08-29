<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'feature', 'can_create', 'can_read', 'can_update', 'can_delete'];

    protected $casts = [
        'can_create' => 'boolean',
        'can_read'   => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
