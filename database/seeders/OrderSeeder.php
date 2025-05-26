<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $statuses = ['pending', 'paid', 'shipped', 'delivered'];

        // Ambil 2 customer
        $customerIds = DB::table('users')
            ->where('role', 'customer')
            ->take(2)
            ->pluck('user_id');

        // Ambil semua produk
        $products = DB::table('products')->get()->shuffle();

        foreach ($customerIds as $userId) {
            $selectedProducts = $products->splice(0, 2);
            $totalPrice = 0;

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'promo_id' => null,
                'order_date' => now(),
                'order_status' => $statuses[array_rand($statuses)],
                'total_price' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $price = $product->price;

                DB::table('order_details')->insert([
                    'order_id' => $orderId,
                    'product_id' => $product->product_id,
                    'product_size' => $sizes[array_rand($sizes)], // Now includes XL
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalPrice += $qty * $price;
            }

            DB::table('orders')->where('order_id', $orderId)->update([
                'total_price' => $totalPrice
            ]);
        }
    }
}