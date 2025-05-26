<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('promos')->insert([
            [
                'code' => 'BLACKFRI50',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(10),
                'discount_amount' => 50, // 50%
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NEWYEAR20',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(15),
                'discount_amount' => 20, // 20%
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WELCOME10',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'discount_amount' => 10, // 10%
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}