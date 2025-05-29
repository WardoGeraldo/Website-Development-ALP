<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $name = $request->input('name');
        $price = $request->input('price');
        $size = $request->input('size');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        // Generate unique key using productId + size (to differentiate sizes)
        $key = $productId . '-' . $size;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'name' => $name,
                'price' => $price,
                'size' => $size,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    
    public function index(Request $request)
    {
        // Check if the cart exists in the session, otherwise set it with dummy data
    if (!session()->has('cart') || empty(session()->get('cart'))) {            
        $cart = [
            1 => ['name' => 'Oversized Tee', 'price' => 299000, 'quantity' => 1],
            2 => ['name' => 'Slim Fit Pants', 'price' => 399000, 'quantity' => 2],
            3 => ['name' => 'Monochrome Cap', 'price' => 149000, 'quantity' => 1],
            4 => ['name' => 'Wisdom Cap', 'price' => 149000, 'quantity' => 1]
        ];
        session()->put('cart', $cart); // Store cart in session
    }

        $cart = session()->get('cart');
        $promo = session()->get('promo', null);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discountAmount = 0;
        $discountRate = 0;
        $promoCode = '';

        if ($promo) {
            $discountRate = $promo['discount'] ?? 0;
            $promoCode = $promo['code'] ?? '';
            $discountAmount = $total * $discountRate;
        }

        $finalTotal = $total - $discountAmount;

        return view('cart', [
            'cart' => $cart,
            'promoCode' => $promoCode,
            'discountRate' => $discountRate,
            'discountAmount' => $discountAmount,
            'finalTotal' => $finalTotal,
        ]);
    }

    // Remove an item from the cart
    public function remove($id, Request $request)
    {
        $cart = session()->get('cart');

        // If item exists in the cart, remove it
        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove the item from the cart
            session()->put('cart', $cart); // Save the updated cart back to the session
            return redirect()->route('cart.index')->with('success', 'Item removed from the cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found.');
    }

    public function bulkUpdate(Request $request)
{
        $quantities = $request->input('quantities', []);
        $cart = session()->get('cart', []);

        foreach ($quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int) $qty); // safe fallback
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated successfully.');
    }
    
    public function checkout(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        $cart = session()->get('cart', []);
        $selectedItems = [];

        foreach ($selectedIds as $id) {
            if (isset($cart[$id])) {
                $selectedItems[$id] = $cart[$id];
            }
        }

        // Store selected items temporarily for checkout
        session()->put('checkout_items', $selectedItems);

        // Redirect to the checkout-detail page
        return redirect()->route('cart.checkoutDetail');
    }

    public function applyPromo(Request $request)
    {   
        $validPromo = ['BLACKFRI50', 'NEWYEAR20'];
        
        $promoCode = strtoupper($request->input('promo'));
        if ($promoCode == $validPromo[0]) {
            $discountRate = 0.50;
            session()->put('promo', [
                'code' => $promoCode,
                'discount' => $discountRate,
            ]);

            return redirect()->back()->with([
                'success' => 'Promo code applied successfully!',
            ]);
        }
        else if ($promoCode == $validPromo[1]) {
            $discountRate = 0.20;
            session()->put('promo', [
                'code' => $promoCode,
                'discount' => $discountRate,
            ]);

            return redirect()->back()->with([
                'success' => 'Promo code applied successfully!',
            ]);
        }
        session()->forget('promo'); // Clear invalid promo
        return redirect()->back()->with('error', 'Invalid promo code.');
    }


    public function checkoutDetail()
    {
        $selectedItems = session()->get('checkout_items', []);

        $user = [
            'email' => 'user@example.com',
            'address' => 'Jl. Example No. 123, Jakarta',
            'contact' => '08123456789'
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