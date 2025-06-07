<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $primaryKey = 'product_image_id'; // karena bukan id default
    protected $fillable = [
        'product_id',
        'url',
        'is_primary',
        'status_del',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
