<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_id');
    }
}
