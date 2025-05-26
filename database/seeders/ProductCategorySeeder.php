<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Top',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bottom',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bag',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Accessories',
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}