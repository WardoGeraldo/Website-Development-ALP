<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['code', 'start_date', 'end_date', 'discount', 'is_used'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount' => 'float',
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_id');
    }
}
