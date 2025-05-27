<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Pastel Shirt',
                'description' => 'A stylish shirt that could never go wrong for casual or professional work.',
                'price' => 299000,
                'category_id' => 1, // Top
            ],
            [
                'name' => 'Black Veravia Signature Dress',
                'description' => 'A Stylish dress for modern look that will light up your charm',
                'price' => 499000,
                'category_id' => 1, // Top
            ],
            [
                'name' => 'Oversized Pink Tee',
                'description' => 'Perfect for a smart casual look.',
                'price' => 299000,
                'category_id' => 1, // Top
            ],
            [
                'name' => 'Long-Sleeved Green Shirt',
                'description' => 'A long-sleeved shirt with a premium wool',
                'price' => 349000,
                'category_id' => 1, // Top
            ],
            [
                'name' => 'Pastel Fit Pants',
                'description' => 'A simple, yet fits with every top you have',
                'price' => 449000,
                'category_id' => 2, // Bottom
            ],
            [
                'name' => 'Black Wool Underwear',
                'description' => 'Made with premium sheep wool to make you comfy',
                'price' => 129000,
                'category_id' => 2, // Bottom
            ],
            [
                'name' => 'Denim Baggy Jeans',
                'description' => 'A simple, yet stylish baggy jeans to complement your outfit of the day.',
                'price' => 649000,
                'category_id' => 2, // Bottom
            ],
            [
                'name' => 'Sunkist Cap',
                'description' => 'A stylish cap to complement your outfit during the day.',
                'price' => 249000,
                'category_id' => 4, // Accessories
            ],
            [
                'name' => 'Brown Wisdom Cap',
                'description' => 'A simple, yet stylish cap to complement your outfit.',
                'price' => 249000,
                'category_id' => 4, // Accessories
            ],
            [
                'name' => 'Brown Leather Bag',
                'description' => 'A simple, yet real leathered bag with a sand color.',
                'price' => 1149000,
                'category_id' => 3, // Bag
            ],
            [
                'name' => 'Pink Captain Bag',
                'description' => 'A sweet pastel pink look that will make you charm',
                'price' => 1549000,
                'category_id' => 3, // Bag
            ],
            [
                'name' => 'Abstract Leather Bag',
                'description' => 'An abstract leather bag that will make you feel obsessed.',
                'price' => 1649000,
                'category_id' => 3, // Bag
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $product['category_id'],
                'status_del' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}