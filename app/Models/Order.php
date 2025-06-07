<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'user_id',
        'promo_id',
        'order_status',
        'total_price',
        'order_date'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


    public function orderDetails()
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
