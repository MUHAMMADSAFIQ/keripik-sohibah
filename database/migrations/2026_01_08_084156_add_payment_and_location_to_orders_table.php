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
            if (!Schema::hasColumn('orders', 'latitude')) {
                $table->string('latitude')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'longitude')) {
                $table->string('longitude')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->default('cod')->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'sender_name')) {
                $table->string('sender_name')->nullable()->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('total_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'payment_method', 'payment_status', 'sender_name', 'payment_proof']);
        });
    }
};
