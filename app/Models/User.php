<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id'; // ✅ ADD THIS!

    public function cart()
    {
        return $this->hasOne(Cart::class, 'cart_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id', 'user_id');
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'wishlist_id', 'user_id');
    }

    protected $fillable = [
    'name', 
    'email', 
    'password', 
    'role',
    'address',        
    'phone_number',  
    'birthdate',      
    'status_del', 
];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
