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
            $table->text('shipping_address')->nullable()->after('order_date');
            $table->string('courier_name')->nullable()->after('shipping_address');
            $table->string('courier_service')->nullable()->after('courier_name');
            $table->string('tracking_number')->nullable()->after('courier_service');
            $table->string('payment_method')->nullable()->after('tracking_number');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('payment_method');
            $table->json('payment_details')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address',
                'courier_name',
                'courier_service',
                'tracking_number',
                'payment_method',
                'payment_status',
                'payment_details',
            ]);
        });
    }
};
