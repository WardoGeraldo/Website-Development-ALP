<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin 1',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'address' => 'Jl. Yes No. 1, Jakarta',
                'phone_number' => '081234567890',
                'birthdate' => '1990-01-01',
                'role' => 'admin',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Budi Dotkom',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('budi123'),
                'address' => 'Jl. Merr No. 2, Surabaya',
                'phone_number' => '082233445566',
                'birthdate' => '1995-05-10',
                'role' => 'customer',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Troy Chan',
                'email' => 'troy@gmail.com',
                'password' => Hash::make('sudjuni'),
                'address' => 'Jl. Shawn Chan No. 3, Surabaya',
                'phone_number' => '083344556677',
                'birthdate' => '1998-09-22',
                'role' => 'customer',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}