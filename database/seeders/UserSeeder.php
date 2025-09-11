<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin@gmail.com', // This should be hashed in a real application
            'status' => 'active',
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'nasabah',
            'email' => 'nasabah@gmail.com',
            'password' => 'nasabah', // This should be hashed in a real application
            'status' => 'active',
            'role' => 'nasabah',
        ]);
    }

    //
}
