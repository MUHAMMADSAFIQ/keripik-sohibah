<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('chat_messages')) {
            Schema::table('chat_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('chat_messages', 'user_name')) {
                    $table->string('user_name')->nullable();
                }
                if (!Schema::hasColumn('chat_messages', 'user_phone')) {
                    $table->string('user_phone')->nullable();
                }
                if (!Schema::hasColumn('chat_messages', 'admin_online')) {
                    $table->boolean('admin_online')->default(false);
                }
            });
        }
    }

    public function down()
    {
        // Safe to ignore
    }
};
