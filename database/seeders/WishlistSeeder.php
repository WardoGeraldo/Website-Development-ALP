<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 2 customer
        $customerIds = DB::table('users')
            ->where('role', 'customer')
            ->take(2)
            ->pluck('user_id');

        // Ambil semua produk, acak
        $productIds = DB::table('products')->pluck('product_id')->shuffle();

        foreach ($customerIds as $userId) {
            // Ambil 2 produk unik untuk user ini
            $selectedProducts = $productIds->splice(0, 2);

            foreach ($selectedProducts as $productId) {
                DB::table('wishlists')->insert([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}