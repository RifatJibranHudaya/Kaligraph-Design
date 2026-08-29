<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_alat', 150);
            $table->decimal('harga', 12, 0)->default(0);
            $table->string('tempat_beli', 150)->nullable();
            $table->string('merk', 100)->nullable();
            $table->integer('periode_ganti')->default(0)->comment('in months');
            $table->date('tanggal_beli')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational');
    }
};
