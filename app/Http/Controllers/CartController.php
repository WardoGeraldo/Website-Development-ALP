<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
        $userId = Auth::id();

        // Fetch cart items from database, including product info
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->product_qty;
        }

        $promo = session()->get('promo', null);
        $discountRate = $promo['discount'] ?? 0;
        $promoCode = $promo['code'] ?? '';
        $discountAmount = $total * $discountRate;
        $finalTotal = $total - $discountAmount;

        return view('cart', [
            'cartItems' => $cartItems,
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
            $cartItem = Cart::where('cart_id', $cartId)->where('user_id', $userId)->first();
            if ($cartItem) {
                $cartItem->product_qty = max(1, (int) $qty); // prevent 0 or negative qty
                $cartItem->save();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
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