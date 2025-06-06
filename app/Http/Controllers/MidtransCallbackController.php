<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            // Use Midtrans SDK to parse the callback
            $json = file_get_contents("php://input");
            $data = json_decode($json);

            if (!$data) {
                Log::error('Invalid JSON from Midtrans');
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            $orderId = $data->order_id ?? null;
            $transactionStatus = $data->transaction_status ?? null;
            $paymentType = $data->payment_type ?? null;
            $grossAmount = $data->gross_amount ?? null;
            $transactionId = $data->transaction_id ?? null;
            $vaNumber = $data->va_numbers[0]->va_number ?? null;
            $bank = $data->va_numbers[0]->bank ?? null;
            $settlementTime = $data->settlement_time ?? null;
            $pdfUrl = $data->pdf_url ?? null;

            Log::info('Midtrans parsed callback:', compact(
                'orderId', 'transactionStatus', 'transactionId', 'paymentType', 'grossAmount', 'vaNumber', 'bank'
            ));

            // Fetch the order
            $order = Order::find($orderId);
            if (!$order) {
                Log::error('Order not found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update or create the payment record
            $payment = Payment::where('order_id', $orderId)->first();
            if ($payment) {
                $payment->update([
                    'transaction_id'     => $transactionId,
                    'payment_type'       => $paymentType,
                    'transaction_status' => $transactionStatus,
                    'amount'             => $grossAmount,
                    'payment_date'       => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
                    'va_number'          => $vaNumber,
                    'bank'               => $bank,
                    'pdf_url'            => $pdfUrl,
                ]);
            } else {
                Payment::create([
                    'order_id'           => $orderId,
                    'transaction_id'     => $transactionId,
                    'payment_type'       => $paymentType,
                    'transaction_status' => $transactionStatus,
                    'amount'             => $grossAmount,
                    'payment_date'       => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
                    'va_number'          => $vaNumber,
                    'bank'               => $bank,
                    'pdf_url'            => $pdfUrl,
                ]);
            }

            // Update order status
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    $order->order_status = 'paid';
                    break;
                case 'pending':
                    $order->order_status = 'pending';
                    break;
                case 'deny':
                case 'cancel':
                case 'expire':
                    $order->order_status = 'failed';
                    break;
            }

            $order->save();

            return response()->json(['message' => 'Callback processed successfully.']);
        } catch (\Exception $e) {
            Log::error('Midtrans callback error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Callback failed.'], 500);
        }
    }
}
