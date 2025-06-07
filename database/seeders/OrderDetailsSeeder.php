<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];

        // Ambil semua order
        $orders = DB::table('orders')->get();

        // Ambil semua produk
        $products = DB::table('products')->get()->shuffle();

        foreach ($orders as $order) {
            $selectedProducts = $products->splice(0, 2);
            $totalPrice = 0;

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $price = $product->price;

                DB::table('order_details')->insert([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'product_size' => $sizes[array_rand($sizes)],
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalPrice += $qty * $price;
            }

            // Update total harga di tabel orders
            DB::table('orders')->where('order_id', $order->order_id)->update([
                'total_price' => $totalPrice
            ]);
        }
    }
}