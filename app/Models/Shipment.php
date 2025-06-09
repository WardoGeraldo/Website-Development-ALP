<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $primaryKey = 'shipment_id';
    public $timestamps = true;
    protected $fillable = [
        'order_id', 'first_name', 'last_name',
        'address_line1', 'address_line2', 'city',
        'zip_code', 'phone', 'shipment_date', 'delivery_date', 'delivery_status'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
