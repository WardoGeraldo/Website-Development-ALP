<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    protected $sales;

    public function __construct()
    {
        // Initialize sales array here
        $this->sales = [
            1 => [
                'id' => 1,
                'transaction_date' => '2023-10-01',
                'total_price' => 598000,
                'status' => 'completed',
            ],
            2 => [
                'id' => 2,
                'transaction_date' => '2023-10-01',
                'total_price' => 598000,
                'status' => 'pending',
            ],
        ];
    }

    public function index()
    {
        return view('sales.index', [
            'sales' => $this->sales
        ]);
    }
}
