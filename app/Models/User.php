<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'level',
        'user_type',
        'branch_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ─── Relationships ───────────────────────────────────────

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ─── Type Helpers ────────────────────────────────────────

    public function isCustomer(): bool
    {
        return $this->user_type === 'customer';
    }

    public function isAdminUser(): bool
    {
        return $this->user_type === 'admin';
    }

    // ─── Role Helpers ────────────────────────────────────────

    public function isSuperadmin(): bool
    {
        return $this->level === 'superadmin';
    }

    public function isOwner(): bool
    {
        return in_array($this->level, ['superadmin', 'owner']);
    }

    public function isAdmin(): bool
    {
        return in_array($this->level, ['superadmin', 'owner', 'admin']);
    }

    public function hasRole(string|array $roles): bool
    {
        if ($this->isSuperadmin()) return true;
        $roles = is_array($roles) ? $roles : [$roles];
        return in_array($this->level, $roles);
    }

    public function hasPermission(string $feature, string $action = 'read'): bool
    {
        if ($this->isSuperadmin()) return true;

        $col = match ($action) {
            'create' => 'can_create',
            'update' => 'can_update',
            'delete' => 'can_delete',
            default  => 'can_read',
        };

        // For customer users, check role-based permissions first
        if ($this->isCustomer() || $this->level === 'customer') {
            $rolePerm = RolePermission::where('role', 'customer')
                ->where('feature', $feature)
                ->first();

            if ($rolePerm) {
                return (bool) $rolePerm->{$col};
            }
        }

        return $this->permissions()
            ->where('feature', $feature)
            ->where($col, true)
            ->exists();
    }

    // ─── Display Helpers ─────────────────────────────────────

    public function levelLabel(): string
    {
        return match ($this->level) {
            'superadmin'     => '⭐ Superadmin',
            'owner'          => '👑 Owner',
            'admin'          => '🛡️ Admin',
            'admin_cadangan' => '🔵 Admin Cadangan',
            'kasir'          => '💼 Kasir',
            'customer'       => '🛍️ Pelanggan',
            default          => $this->level,
        };
    }

    public function levelBadgeClass(): string
    {
        return match ($this->level) {
            'superadmin'     => 'badge-superadmin',
            'owner'          => 'badge-owner',
            'admin'          => 'badge-admin',
            'admin_cadangan' => 'badge-cadangan',
            'kasir'          => 'badge-kasir',
            'customer'       => 'badge-customer',
            default          => 'badge-default',
        };
    }

    public function initial(): string
    {
        return strtoupper(mb_substr($this->username, 0, 1));
    }
}
