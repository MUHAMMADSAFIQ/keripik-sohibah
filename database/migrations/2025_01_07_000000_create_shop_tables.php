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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable(); // Path to image
            $table->enum('category', ['keripik', 'pulsa', 'gas_galon', 'other'])->default('keripik');
            $table->integer('stock')->default(0);
            $table->boolean('is_ready')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->boolean('is_approved')->default(false); // Admin approval
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->text('address');
            $table->string('phone');
            $table->string('delivery_method'); // 'delivery', 'pickup'
            $table->decimal('distance_meters', 10, 2)->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'delivering', 'completed', 'cancelled', 'out_of_stock'])->default('pending');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Snapshot of price at time of order
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('message');
            $table->text('admin_reply')->nullable();
            $table->timestamps();
        });
        
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('info')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('products');
    }
};
