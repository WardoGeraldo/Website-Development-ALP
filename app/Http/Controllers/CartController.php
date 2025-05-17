<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // public function show(){
    //     return view('cart');
    // }

    // Display the cart contents
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
        } else {
            $cart = session()->get('cart'); // Retrieve cart from session
        }

        // Debugging: Dump the cart data stored in the session
        // dd($cart);
        return view('cart', ['cart' => $cart]);
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
        $selected = $request->input('selected', []);
        $cart = session()->get('cart', []);

        foreach ($selected as $id) {
            unset($cart[$id]); // Remove only selected items
        }

        session()->put('cart', $cart); // Save updated cart
        return redirect()->route('cart.index')->with('success', 'Checkout successful! Selected items removed.');
    }
}