<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify level column to VARCHAR(50) so it supports 'customer', 'superadmin', 'owner', 'admin', 'kasir', 'admin_cadangan'
        Schema::table('users', function (Blueprint $table) {
            $table->string('level', 50)->default('customer')->change();
        });

        // Update all users who are customers to have level = 'customer'
        DB::table('users')
            ->where('user_type', 'customer')
            ->update(['level' => 'customer']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('level', ['superadmin', 'owner', 'admin', 'kasir', 'admin_cadangan', 'customer'])->default('customer')->change();
        });
    }
};
