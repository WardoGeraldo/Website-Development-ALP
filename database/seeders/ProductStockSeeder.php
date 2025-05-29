<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStockSeeder extends Seeder
{
    public function run(): void
    {
        $multiSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $singleSize = 'One Size';

        // Get category IDs by name
        $categoryIds = DB::table('product_categories')->pluck('category_id', 'name');

        $multiSizeCategoryIds = [
            $categoryIds['Top'] ?? null,
            $categoryIds['Bottom'] ?? null,
        ];

        // Get all products
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            if (in_array($product->category_id, $multiSizeCategoryIds)) {
                foreach ($multiSizes as $index => $size) {
                    DB::table('product_stocks')->insert([
                        'product_id' => $product->product_id,
                        'size' => $size,
                        // Set first product’s first size to 0 for stock testing
                        'quantity' => ($index === 0 && $product->product_id === $products->first()->product_id) ? 0 : rand(1, 20),
                        'low_stock_threshold' => 5,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                DB::table('product_stocks')->insert([
                    'product_id' => $product->product_id,
                    'size' => $singleSize,
                    'quantity' => rand(5, 15),
                    'low_stock_threshold' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
