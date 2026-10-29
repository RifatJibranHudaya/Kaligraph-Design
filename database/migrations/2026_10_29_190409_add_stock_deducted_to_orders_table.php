<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('stock_deducted')->default(false)->after('payment_status');
        });

        // Mark existing verified orders as already stock_deducted
        \DB::table('orders')
            ->where('payment_status', 'verified')
            ->update(['stock_deducted' => true]);

        // Fix order 97 if exists: restore erroneously decremented stock for pending order 97
        $order97 = \DB::table('orders')->where('id', 97)->where('payment_status', 'pending')->first();
        if ($order97) {
            $item = \DB::table('order_items')->where('order_id', 97)->first();
            if ($item && $item->product_id) {
                \DB::table('products')->where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stock_deducted');
        });
    }
};
