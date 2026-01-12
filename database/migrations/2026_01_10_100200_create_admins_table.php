<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Copy existing admins from users table to admins table
        $existingAdmins = DB::table('users')->where('is_admin', true)->get();
        
        foreach ($existingAdmins as $admin) {
            DB::table('admins')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password, // Password hash is compatible
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Fallback: If no admins found, create a default one
        if ($existingAdmins->isEmpty()) {
             DB::table('admins')->insert([
                'name' => 'Administrator',
                'email' => 'admin@sohibah.com',
                'password' => Hash::make('password123'), // Default password
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
