<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('receipt_path')->nullable()->after('total');
            $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending')->after('receipt_path');
            $table->unsignedBigInteger('payment_verified_by')->nullable()->after('payment_status');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_verified_by');
            $table->foreign('payment_verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_verified_by']);
            $table->dropColumn(['receipt_path', 'payment_status', 'payment_verified_by', 'payment_verified_at']);
        });
    }
};
?>
