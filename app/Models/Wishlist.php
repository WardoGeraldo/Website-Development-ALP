<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Wishlist extends Model
{
    protected $primaryKey = 'wishlist_id';
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Correct relationship: each wishlist belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Correct relationship: each wishlist item belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
