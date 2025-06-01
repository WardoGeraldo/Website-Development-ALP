<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    }


    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'order_id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }
}
