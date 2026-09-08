<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50); // e.g., 'customer', 'kasir', 'admin'
            $table->string('feature', 50);
            $table->boolean('can_read')->default(true);
            $table->boolean('can_create')->default(true);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->timestamps();

            $table->unique(['role', 'feature']);
        });

        // Seed default Customer Role permissions
        $customerFeatures = [
            'cust_create_order'     => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
            'cust_order_tracking'   => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
            'cust_payment_confirm'  => ['read' => true, 'create' => true, 'update' => true,  'delete' => false],
            'cust_catalog_view'     => ['read' => true, 'create' => false, 'update' => false, 'delete' => false],
            'cust_order_history'    => ['read' => true, 'create' => false, 'update' => false, 'delete' => false],
            'cust_download_invoice' => ['read' => true, 'create' => true, 'update' => false, 'delete' => false],
        ];

        foreach ($customerFeatures as $feat => $perms) {
            DB::table('role_permissions')->insert([
                'role'       => 'customer',
                'feature'    => $feat,
                'can_read'   => $perms['read'],
                'can_create' => $perms['create'],
                'can_update' => $perms['update'],
                'can_delete' => $perms['delete'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
