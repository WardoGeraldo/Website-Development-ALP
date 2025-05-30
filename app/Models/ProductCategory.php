<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories'; // if your table is plural (Laravel's default)
    protected $primaryKey = 'category_id';

    // Category has many products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
