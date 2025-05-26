<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $methods = ['credit_card', 'bank_transfer', 'e-wallet'];
        $statuses = ['paid', 'pending', 'failed'];

        // Ambil semua order yang status-nya "paid"
        $paidOrders = DB::table('orders')
            ->where('order_status', 'paid')
            ->get();

        foreach ($paidOrders as $order) {
            DB::table('payments')->insert([
                'order_id' => $order->order_id,
                'payment_type' => $methods[array_rand($methods)],
                'transaction_status' => 'paid',
                'payment_date' => now(),
                'amount' => $order->total_price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}