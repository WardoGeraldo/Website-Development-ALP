<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoices;
    protected $customer;
    protected $paymentDetail;

    public function salesList()
    {
        $sales = Order::all();
        return view('sales.index', compact('sales'));
    }


    public function index($sales_id)
    {
        $order = Order::with('details', 'user')->where('order_id', $sales_id)->firstOrFail();

        return view('invoice.index', [
            'order' => $order
        ]);
    }
}
