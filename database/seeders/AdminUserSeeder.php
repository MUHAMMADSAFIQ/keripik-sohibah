<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@sohibah.com'],
            [
                'name' => 'Admin Owner',
                'password' => Hash::make('rahasia123'), // Default password
            ]
        );
    }
}
