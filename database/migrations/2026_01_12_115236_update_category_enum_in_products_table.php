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
        // Use raw SQL to update ENUM. Note: This assumes MySQL.
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('keripik', 'pulsa', 'gas_galon', 'other', 'minuman') NOT NULL DEFAULT 'keripik'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('keripik', 'pulsa', 'gas_galon', 'other') NOT NULL DEFAULT 'keripik'");
    }
};
