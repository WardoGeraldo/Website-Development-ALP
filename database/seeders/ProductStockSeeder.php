<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStockSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        // Ambil semua product_id dari tabel products
        $productIds = DB::table('products')->pluck('product_id');

        foreach ($productIds as $productId) {
            foreach ($sizes as $size) {
                DB::table('product_stocks')->insert([
                    'product_id' => $productId,
                    'size' => $size,
                    'quantity' => rand(1, 20),
                    'low_stock_threshold' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}