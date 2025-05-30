<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_details_id', 'order_id');
    }
}
