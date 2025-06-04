<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // Fetch selected cart items from the database
        $selectedItems = Cart::with('product')
            ->where('user_id', $userId)
            ->whereIn('cart_id', $selectedIds)
            ->get();

        // Convert to array format for checkout-detail
        $checkoutItems = [];
        foreach ($selectedItems as $item) {
            $checkoutItems[] = [
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->product_qty,
            ];
        }

        // Store selected items in session
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
    public function orderHistory()
    {
        $orders = session()->get('order_history', []);
        return view('orders-history', compact('orders'));
    }
}