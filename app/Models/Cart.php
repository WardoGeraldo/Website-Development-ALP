<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'cart_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_has_product', 'cart_id', 'product_id')
                    ->withPivot('cart_product_size', 'cart_product_qty');
    }
}
