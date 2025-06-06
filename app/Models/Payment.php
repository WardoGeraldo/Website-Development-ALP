<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'transaction_status',
        'amount',
        'payment_date',
        'va_number',
        'bank',
        'pdf_url',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
