<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'order_details_id',
        'order_id',
        'product_id',
        'product_size',
        'quantity',
        'price',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');    
    }

}
