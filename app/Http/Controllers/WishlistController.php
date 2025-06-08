<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,product_id',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You must be logged in to add to wishlist.');
        }

        $productId = $request->product_id;

        // Check if product is already in wishlist
        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return back()->with('info', 'This product is already in your wishlist.');
        }

        // Save wishlist entry
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return back()->with('success', 'Product added to wishlist!');
    }

    public function show()
    {
        $userId = Auth::id();
        $wishlistItems = Wishlist::with('product')->where('user_id', $userId)->get();
        // dd($wishlistItems);
        return view('wishlist', compact('wishlistItems'));    
    }

    public function remove(Request $request)
    {
        $userId = Auth::id();
            logger()->info('Trying to remove from wishlist', [
            'user_id' => $userId,
            'product_id' => $request->product_id
        ]);
        Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->delete();

        return redirect()->route('wishlist.show')->with('success', 'Product removed from wishlist.');
    }
}
