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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    // Product has many images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id')->where('status_del', 0);
    }

    public function stock()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id')->where('status_del', 0);
    }

    // Product belongs to many carts
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    // Product belongs to many wishlists
    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'product_wishlist_has_product', 'product_id', 'wishlist_id');
    }
}
