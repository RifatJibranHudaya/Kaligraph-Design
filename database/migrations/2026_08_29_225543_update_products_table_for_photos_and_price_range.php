<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('foto', 255)->nullable()->after('emoji');
            $table->decimal('harga_min', 12, 0)->default(0)->after('harga_default');
            $table->decimal('harga_max', 12, 0)->nullable()->after('harga_min');
            $table->string('emoji', 10)->nullable()->change();
        });

        // Backfill existing products' harga_min with harga_default
        DB::statement('UPDATE products SET harga_min = harga_default WHERE harga_min = 0 OR harga_min IS NULL');
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['foto', 'harga_min', 'harga_max']);
        });
    }
};
