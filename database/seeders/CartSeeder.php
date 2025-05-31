<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];

        // Ambil 2 user_id yang merupakan customer
        $customerIds = DB::table('users')
            ->where('role', 'customer')
            ->take(2)
            ->pluck('user_id');

        // Ambil semua produk
        $productIds = DB::table('products')->pluck('product_id')->shuffle();

        foreach ($customerIds as $userId) {
            // Ambil 2 produk unik dari daftar
            $selectedProducts = $productIds->splice(0, 2);

            foreach ($selectedProducts as $productId) {
                DB::table('carts')->insert([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_size' => $sizes[array_rand($sizes)],
                    'product_qty' => rand(1, 3),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}