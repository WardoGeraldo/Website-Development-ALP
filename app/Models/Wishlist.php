<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'wishlist_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_wishlist_has_product', 'wishlist_id', 'product_id');
    }
}
