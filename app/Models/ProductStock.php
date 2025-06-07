<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $primaryKey = 'product_stock_id'; // <-- PENTING, bukan 'id' default

    protected $fillable = [
        'product_id',
        'size',
        'quantity',
        'low_stock_threshold', // <- ini juga perlu karena field ada
        'status_del',           // <- ini juga perlu kalau mau mass update
    ];

    public $timestamps = true; // Karena ada created_at dan updated_at

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
