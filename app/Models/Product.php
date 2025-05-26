<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id'; // since your PK is not 'id'
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'status_del',
    ];

    // // Example relationship to category (optional, if needed)
    // public function category()
    // {
    //     return $this->belongsTo(ProductCategory::class, 'category_id');
    // }
}
