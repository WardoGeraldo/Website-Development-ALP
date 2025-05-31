<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_size',
        'product_qty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'cart_id');
    }

    public function product()
    {
            return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
