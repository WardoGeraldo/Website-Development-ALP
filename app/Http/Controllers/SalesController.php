<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        // Ambil data dari database + relasi ke shipment
        $sales = Order::with('shipment')->get();

        return view('sales.index', compact('sales'));
    }
}
