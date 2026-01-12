<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index(); // Unique session per user
            $table->string('sender_type'); // 'user', 'ai', 'admin'
            $table->text('message');
            $table->boolean('is_read')->default(false); // Admin sudah baca?
            $table->boolean('admin_online')->default(false); // Admin online saat pesan dikirim?
            $table->timestamp('read_at')->nullable(); // Kapan admin baca
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
