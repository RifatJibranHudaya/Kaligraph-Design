<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPermission;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected array $features = [
        'kasir'        => 'Kasir (POS)',
        'produk'       => 'Kelola Produk',
        'stok'         => 'Kelola Stok',
        'produksi'     => 'Catatan Produksi',
        'operasional'  => 'Biaya Operasional',
        'users'        => 'Manajemen User',
        'akses'        => 'Kelola Akses',
        'activity_log' => 'Activity Log',
        'home_manager' => 'Kelola Landing Page',
    ];

    public function index()
    {
        $users = User::with('permissions')->where('level', '!=', 'superadmin')->get();
        $features = $this->features;

        return view('akses.index', compact('users', 'features'));
    }

    public function update(Request $request, User $user)
    {
        $permissions = $request->input('permissions', []);

        foreach ($this->features as $featureKey => $featureName) {
            $perms = $permissions[$featureKey] ?? [];

            UserPermission::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'feature' => $featureKey,
                ],
                [
                    'can_create' => !empty($perms['create']),
                    'can_read'   => !empty($perms['read']),
                    'can_update' => !empty($perms['update']),
                    'can_delete' => !empty($perms['delete']),
                ]
            );
        }

        ActivityLogService::log(
            'update_permission',
            'akses',
            "Hak akses untuk user '{$user->username}' telah diperbarui",
            $user->id
        );

        return back()->with('success', "Hak akses pengguna '{$user->username}' berhasil diperbarui.");
    }
}
