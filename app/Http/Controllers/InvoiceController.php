<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
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
        $order = Order::with('orderDetails', 'user')->where('order_id', $sales_id)->firstOrFail();

        return view('invoice.index', [
            'order' => $order
        ]);
    }

    public function updateShipmentStatus(Request $request, $shipment_id)
    {
        $request->validate([
            'delivery_status' => 'required|in:ordered,processing,shipped,delivered',
        ]);

        $shipment = Shipment::findOrFail($shipment_id);
        $shipment->delivery_status = $request->input('delivery_status');
        $shipment->save();

        return back()->with('success', 'Shipment status updated successfully.');
    }

}
