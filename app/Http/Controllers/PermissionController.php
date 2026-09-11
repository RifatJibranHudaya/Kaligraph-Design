<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserPermission;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected array $features = [
        'produk'       => 'Kelola Produk',
        'kategori'     => 'Kelola Kategori',
        'portfolio'    => 'Kelola Portofolio',
        'status_order' => 'Status Pengerjaan',
        'pembayaran'   => 'Data Pembayaran',
        'users'        => 'Manajemen User',
        'akses'        => 'Kelola Akses',
        'activity_log' => 'Activity Log',
        'home_manager' => 'Kelola Landing Page',
    ];

    protected array $customerFeatures = [
        'cust_create_order'     => [
            'label' => 'Buat & Checkout Pesanan Baru Online',
            'desc'  => 'Izinkan pelanggan membuat dan mengirim pesanan baru melalui form order online portal.'
        ],
        'cust_order_tracking'   => [
            'label' => 'Tracking Status & Progres Pengerjaan',
            'desc'  => 'Izinkan pelanggan memantau status pesanan (Order, On Progress, Selesai, Cancelled) secara real-time.'
        ],
        'cust_payment_confirm'  => [
            'label' => 'Upload Bukti & Konfirmasi Pembayaran',
            'desc'  => 'Izinkan pelanggan mengunggah struk/bukti transfer bank dan konfirmasi pelunasan.'
        ],
        'cust_catalog_view'     => [
            'label' => 'Lihat Katalog & Estimasi Biaya',
            'desc'  => 'Izinkan pelanggan meninjau katalog produk, spesifikasi, dan kisaran harga di portal.'
        ],
        'cust_order_history'    => [
            'label' => 'Riwayat & Rincian Pesanan Pelanggan',
            'desc'  => 'Izinkan pelanggan melihat arsip riwayat seluruh transaksi dan pesanan terdahulu.'
        ],
        'cust_download_invoice' => [
            'label' => 'Cetak & Unduh Faktur / Nota Pesanan',
            'desc'  => 'Izinkan pelanggan mencetak struk transaksi atau mengunduh invoice digital.'
        ],
    ];

    /**
     * Staf / Admin Permissions Matrix.
     */
    public function index()
    {
        $staffUsers = User::with('permissions')
            ->where(function ($q) {
                $q->whereNull('user_type')->orWhere('user_type', 'admin');
            })
            ->where('level', '!=', 'superadmin')
            ->where('level', '!=', 'customer')
            ->get();

        $features = $this->features;

        return view('akses.index', compact('staffUsers', 'features'));
    }

    /**
     * Customer Level / Global Customer Permissions.
     */
    public function pelanggan()
    {
        $customerCount = User::where(function ($q) {
            $q->where('user_type', 'customer')
              ->orWhere('level', 'customer');
        })->count();

        $rolePermissions = RolePermission::where('role', 'customer')->get()->keyBy('feature');
        $customerFeatures = $this->customerFeatures;

        return view('akses.pelanggan', compact('customerCount', 'rolePermissions', 'customerFeatures'));
    }

    /**
     * Update individual staff permissions.
     */
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
            "Hak akses untuk staf '{$user->username}' ({$user->levelLabel()}) telah diperbarui",
            $user->id
        );

        return back()->with('success', "Hak akses staf '{$user->username}' berhasil diperbarui.");
    }

    /**
     * Update global customer role permissions (applies to all customers).
     */
    public function updatePelangganLevel(Request $request)
    {
        $permissions = $request->input('permissions', []);

        foreach ($this->customerFeatures as $featureKey => $featureInfo) {
            $perms = $permissions[$featureKey] ?? [];

            RolePermission::updateOrCreate(
                [
                    'role'    => 'customer',
                    'feature' => $featureKey,
                ],
                [
                    'can_read'   => !empty($perms['read']),
                    'can_create' => !empty($perms['create']),
                    'can_update' => !empty($perms['update']),
                    'can_delete' => !empty($perms['delete']),
                ]
            );
        }

        ActivityLogService::log(
            'update_customer_permissions',
            'akses',
            "Hak akses Level Pelanggan (Semua Pelanggan) telah diperbarui"
        );

        return back()->with('success', "Hak akses Level Pelanggan (Semua Pelanggan) berhasil diperbarui dan langsung aktif.");
    }
}
