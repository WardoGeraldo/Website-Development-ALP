<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $primaryKey = 'promo_id'; // PK custom
    public $incrementing = true;        // Auto increment
    protected $keyType = 'int';          // Tipe primary key

    protected $fillable = [
        'code', 
        'discount_amount', 
        'start_date', 
        'end_date', 
        'status_del',  // Jangan lupa dimasukkin ke fillable
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount' => 'float',
        'status_del' => 'boolean', // True = deleted
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_id', 'promo_id');
    }
}
