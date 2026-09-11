<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->string('group', 50)->default('general');
                $table->string('description', 255)->nullable();
                $table->timestamps();
            });

            // Insert default WhatsApp settings
            DB::table('settings')->insert([
                [
                    'key' => 'whatsapp_number',
                    'value' => '6281234567890',
                    'group' => 'contact',
                    'description' => 'Nomor WhatsApp Utama untuk seluruh tombol kontak & konsultasi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'whatsapp_default_message',
                    'value' => 'Halo Kaligraph Design, saya ingin konsultasi pesanan neon box & signage.',
                    'group' => 'contact',
                    'description' => 'Pesan default konsultasi WhatsApp',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
