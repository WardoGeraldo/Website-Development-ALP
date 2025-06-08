<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_size' => 'required|in:XS,S,M,L,XL,XXL,One Size',
            'product_qty' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $size = $request->product_size;
        $qtyToAdd = $request->product_qty;

        // Get available stock from product_stocks table
        $availableStock = DB::table('product_stocks')
            ->where('product_id', $productId)
            ->where('size', $size)
            ->value('quantity');

        if (!$availableStock) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        // Check if item already exists in user's cart
        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('product_size', $size)
            ->first();

        $totalQty = $qtyToAdd;
        if ($existingCartItem) {
            $totalQty += $existingCartItem->product_qty;
        }

        // If total desired quantity exceeds available stock
        if ($totalQty > $availableStock) {
            return back()->with('error', 'Insufficient stock available for this size. Only ' . $availableStock . ' left.');
        }

        // Save or update cart
        if ($existingCartItem) {
            $existingCartItem->product_qty = $totalQty;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'product_size' => $size,
                'product_qty' => $qtyToAdd,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    
    public function index()
    {
        // dd(session()->all());
        $userId = Auth::id();

        // Fetch cart items from database, including product info
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->product_qty;
        }

        // Promo session check
        $promo = session()->get('promo', null);
        $discountRate = $promo['discount'] ?? 0;
        $promoCode = $promo['code'] ?? '';

        // Calculate discount and final total
        $discountAmount = $subtotal * $discountRate;
        $finalTotal = $subtotal - $discountAmount;

        return view('cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'promoCode' => $promoCode,
            'discountRate' => $discountRate,
            'discountAmount' => $discountAmount,
            'finalTotal' => $finalTotal,
        ]);
    }


    // Remove an item from the cart
    public function remove($id, Request $request)
    {
        $userId = Auth::id();

        $cartItem = Cart::where('cart_id', $id)->where('user_id', $userId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from the cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found.');
    }

    public function bulkUpdate(Request $request)
    {
        $quantities = $request->input('quantities', []);
        $userId = Auth::id();

        foreach ($quantities as $cartId => $qty) {
            $cartItem = Cart::where('cart_id', $cartId)
                            ->where('user_id', $userId)
                            ->with('product') // eager load the related product
                            ->first();

            if ($cartItem) {
                $desiredQty = max(1, (int) $qty);
                $availableStock = $cartItem->product->stock()
                    ->where('size', $cartItem->product_size)
                    ->sum('quantity');

                if ($desiredQty <= $availableStock) {
                    $cartItem->product_qty = $desiredQty;
                    $cartItem->save();
                } else {
                    $errors = [];
                    foreach ($quantities as $cartId => $qty) {
                        $cartItem = Cart::with('product.stock')->where('cart_id', $cartId)->where('user_id', $userId)->first();

                        if ($cartItem) {
                            $availableStock = $cartItem->product->stock
                                ->where('size', $cartItem->product_size)
                                ->sum('quantity');

                            if ($qty > $availableStock) {
                                $errors["stock_error_{$cartId}"] = "Quantity for {$cartItem->product->name} exceeds available stock (max: {$availableStock}).";
                            } else {
                                $cartItem->product_qty = max(1, (int) $qty);
                                $cartItem->save();
                            }
                        }
                    }
                    if (!empty($errors)) {
                        return redirect()->route('cart.index')->withErrors($errors);
                    }
                }
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    
    public function checkout(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        $userId = Auth::id();

        $selectedItems = Cart::with('product.stock')
            ->where('user_id', $userId)
            ->whereIn('cart_id', $selectedIds)
            ->get();

        $checkoutItems = [];
        $errors = [];

        foreach ($selectedItems as $item) {
            $availableStock = $item->product->stock
                ->where('size', $item->product_size)
                ->sum('quantity');

            if ($item->product_qty > $availableStock) {
                $errors["stock_error_{$item->cart_id}"] = "Stock not enough for {$item->product->name} size {$item->product_size} (available: {$availableStock}).";
            } else {
                $checkoutItems[] = [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->product_qty,
                    'size' => $item->product_size,
                ];
            }
        }

        if (!empty($errors)) {
            return redirect()->route('cart.index')->withErrors($errors);
        }

        session()->put('checkout_items', $checkoutItems);

        return redirect()->route('cart.checkoutDetail');
    }



    public function applyPromo(Request $request)
    {   
        $promoCode = strtoupper($request->input('promo'));
        $now = Carbon::now();

        $promo = Promo::where('code', $promoCode)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        if ($promo) {
            session()->put('promo', [
                'code' => $promo->code,
                'discount' => $promo->discount_amount / 100, 
                'id' => $promo->promo_id,
            ]);

            return redirect()->route('cart.index')->with('success', 'Promo code applied successfully!');
        }

        session()->forget('promo'); // Clear invalid promo
        return redirect()->back()->with('error', 'Invalid or expired promo code.');
    }


    public function checkoutDetail(Request $request)
    {
        // dd(session()->all());
        $selectedItems = session()->get('checkout_items', []);

        $user = [
            'email' => Auth::user()->email,
        ];

        $orders = array_map(function ($item) {
            return [
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ];
        }, $selectedItems);

        $total = array_reduce($orders, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $promo = session()->get('promo', null);

        $discountRate = 0;
        $promoCode = '';
        $discountAmount = 0;

        if ($promo) {
            $discountRate = $promo['discount'] ?? 0;
            $promoCode = $promo['code'] ?? '';
            $discountAmount = $total * $discountRate;
        }

        $finalTotal = $total - $discountAmount;
        $orderHistory = session()->get('order_history', []);

        $orderHistory[] = [
            'timestamp' => now()->toDateTimeString(),
            'orders' => $orders,
            'total' => $total,
            'discount' => $discountAmount,
            'final_total' => $finalTotal,
            'promo' => $promoCode,
        ];

        session()->put('order_history', $orderHistory);
        return view('checkout-detail', compact(
            'user', 'orders', 'total', 'discountRate', 'discountAmount', 'finalTotal', 'promoCode'
        ));
    }
    public function processCheckout(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address_line1' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
            'phone' => 'required|string',
        ]);
        $user = Auth::user();
        $selectedItems = session('checkout_items', []);
        $promo = session('promo', []);
        $discountRate = is_array($promo) && isset($promo['discount']) ? $promo['discount'] : 0;

        try {
            // 1. Calculate total
            $total = collect($selectedItems)->sum(fn($item) => $item['price'] * $item['quantity']);
            $discountAmount = $total * $discountRate;
            $finalTotal = $total - $discountAmount;

            // 2. Save Order
            $order = Order::create([
                'user_id' => $user->user_id,
                'promo_id' => $promo['id'] ?? null,
                'order_status' => 'pending',
                'total_price' => $finalTotal,
            ]);
            foreach ($selectedItems as $item) {
                OrderDetails::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['product_id'],
                    'product_size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            foreach ($selectedItems as $item) { //REMOVE STOCK AFTER CHECKOUT KURANG race-condition stok validation
                DB::table('product_stocks')
                    ->where('product_id', $item['product_id'])
                    ->where('size', $item['size'])
                    ->decrement('quantity', $item['quantity']);
            }
            Shipment::create([
            'order_id' => $order->order_id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address_line1' => $request->input('address_line1'),
            'address_line2' => $request->input('address_line2'),
            'city' => $request->input('city'),
            'zip_code' => $request->input('zip_code'),
            'phone' => $request->input('phone'),
            'shipment_date' => now(),
            'delivery_date' => now()->addDays(7), // <-- set delivery_date 7days after order
            'delivery_status' => 'processing',
        ]);

            // 3. Midtrans config
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $orderId = $order->getKey();

            // 4. Midtrans params
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $finalTotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'callbacks' => [
                    'finish' => route('store.show'),
                ],
            ];

            // 5. Create Snap URL
            $snap = \Midtrans\Snap::createTransaction($params);
            // ✅ INSERT PENDING PAYMENT *before* the redirect
            \App\Models\Payment::create([
                'order_id' => $order->order_id,
                'transaction_id' => null, // Will be updated by callback
                'payment_type' => null,
                'transaction_status' => 'paid',
                'amount' => $finalTotal,
                'payment_date' => null,
                'va_number' => null,
                'bank' => null,
                'pdf_url' => null,
            ]);

            // dd($snap);
            // 6. Redirect to Midtrans
            return redirect()->away($snap->redirect_url);
        

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to redirect to payment gateway.');
        }
    }

    public function orderHistory()
    {
        $user = Auth::user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'You need to log in to view your order history.');
            }

            $orders = Order::with([
                'orderDetails.product',  // eager load products through orderDetails
                'promo'
            ])
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

            return view('orders-history', compact('orders'));
    }
    public function showShipment($order_id)
    {
        $order = Order::with(['shipment', 'orderDetails.product'])->findOrFail($order_id);
        return view('shipment', compact('order'));
    }
}