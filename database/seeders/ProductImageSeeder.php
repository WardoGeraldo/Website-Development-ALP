<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('product_id');

        foreach ($productIds as $productId) {
            for ($i = 1; $i <= 4; $i++) {
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'url' => "https://dummyimage.com/600x800/cccccc/000000&text=Product+{$productId}+Image+{$i}",
                    'is_primary' => $i === 1, // hanya gambar pertama yang utama
                    'status_del' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}