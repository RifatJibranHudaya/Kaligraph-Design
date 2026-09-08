<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add category_id to products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->nullOnDelete();
        });

        // Add status and customer info to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 20)->default('order')->after('keterangan');
            $table->string('nama_pelanggan', 150)->nullable()->after('status');
            $table->string('no_hp', 20)->nullable()->after('nama_pelanggan');
            $table->text('alamat')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status', 'nama_pelanggan', 'no_hp', 'alamat']);
        });
    }
};
