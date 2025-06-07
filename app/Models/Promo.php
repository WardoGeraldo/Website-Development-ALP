<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $primaryKey = 'promo_id'; // tambahkan baris ini
    protected $fillable = ['code', 'start_date', 'end_date', 'discount_amount'];

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
