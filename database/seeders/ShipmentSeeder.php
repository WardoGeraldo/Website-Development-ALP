<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['processing', 'shipped', 'delivered'];

        // Ambil semua order yang status-nya "paid"
        $paidOrders = DB::table('orders')
            ->where('order_status', 'paid')
            ->get();

        foreach ($paidOrders as $order) {
            DB::table('shipments')->insert([
                'order_id' => $order->order_id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'address_line1' => 'Jl. Contoh No. ' . rand(1, 100),
                'address_line2' => 'Blok B' . rand(1, 9),
                'city' => 'Jakarta',
                'zip_code' => '12345',
                'phone' => '08' . rand(1000000000, 9999999999),
                'shipment_date' => now()->subDays(rand(0, 3)),
                'delivery_status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}