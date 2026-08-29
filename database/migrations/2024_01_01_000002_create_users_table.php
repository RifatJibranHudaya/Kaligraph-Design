<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 20)->nullable();
            $table->string('password', 255);
            $table->enum('level', ['superadmin', 'owner', 'admin', 'kasir', 'admin_cadangan'])->default('kasir');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
