<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;
            $amount = $notification->gross_amount;

            // Example: Match order by order_id
            $order = Order::where('order_id', $orderId)->first();

            if (!$order) {
                // You might want to log this
                Log::warning("Order not found for order_id: {$orderId}");
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Save to payments table
            Payment::create([
                'order_id' => $order->order_id,
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $type,
                'transaction_status' => $transaction,
                'va_number' => $notification->va_numbers[0]->va_number ?? null,
                'bank' => $notification->va_numbers[0]->bank ?? null,
                'pdf_url' => $notification->pdf_url ?? null,
                'amount' => $amount,
                'payment_date' => now(),
            ]);

            // Update order status if settled
            if ($transaction === 'settlement') {
                $order->order_status = 'paid';
                $order->save();
            }

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to process'], 500);
        }
    }
}
