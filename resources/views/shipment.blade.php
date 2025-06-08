@extends('base.base')

@section('content')
<style>
    .shipment-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        font-family: 'Cormorant', serif;
    }

    .shipment-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .shipment-progress {
    margin: 2rem 0 1rem;
    }

    .progress-track {
        position: relative;
        height: 8px;
        background-color: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background-color: #4CAF50;
        transition: width 0.4s ease;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #444;
        padding: 0 2px;
    }


    .progress-step.active {
        background-color: #4CAF50; /* Green for active step */
        box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.2);
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #444;
        padding: 0 10px;
    }

    .timeline {
        margin-top: 2rem;
        border-left: 2px solid #ddd;
        padding-left: 1rem;
    }

    .timeline-entry {
        margin-bottom: 1rem;
        padding-left: 1rem;
    }

    .timeline-entry time {
        display: block;
        font-size: 0.85rem;
        color: #888;
    }

    .product-summary {
        margin-top: 2rem;
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .total {
        text-align: right;
        font-weight: bold;
    }

</style>

<div class="shipment-container">
    <div class="shipment-header">Order Details #{{ $order->order_id }}</div>

    @php
        $shipment = $order->shipment;

        $shipmentDate = \Carbon\Carbon::parse($shipment->shipment_date);
        $deliveryDate = \Carbon\Carbon::parse($shipment->delivery_date);
        $now = \Carbon\Carbon::now();

        $progress = 0;
        if ($now->gte($deliveryDate)) {
            $progress = 100; // Delivered
            $status = 'Delivered';
        } elseif ($now->gte($shipmentDate->copy()->addDays(5))) {
            $progress = 75;
            $status = 'Shipped';
        } elseif ($now->gte($shipmentDate->copy()->addDays(2))) {
            $progress = 50;
            $status = 'Processing';
        } else {
            $progress = 25;
            $status = 'Ordered';
        }
    @endphp


    <div class="shipment-progress">
        <h4>Order Details #{{ $order->order_id }}</h4>
        <div class="progress mt-3 mb-3" style="height: 10px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="d-flex justify-content-between small">
            <span class="{{ $progress >= 25 ? 'fw-bold text-success' : '' }}">Ordered</span>
            <span class="{{ $progress >= 50 ? 'fw-bold text-success' : '' }}">Processing</span>
            <span class="{{ $progress >= 75 ? 'fw-bold text-success' : '' }}">Shipped</span>
            <span class="{{ $progress == 100 ? 'fw-bold text-success' : '' }}">Delivered</span>
        </div>
    </div>


    {{-- Shipment Info --}}
    <div class="shipment-details mt-3 mb-3">
        <strong>Recipient:</strong> {{ $order->shipment->first_name }} {{ $order->shipment->last_name }}<br>
        <strong>Phone:</strong> {{ $order->shipment->phone }}<br>
        <strong>Address:</strong>
        {{ $order->shipment->address_line1 }},
        {{ $order->shipment->address_line2 ?? '' }},
        {{ $order->shipment->city }},
        {{ $order->shipment->zip_code }}<br>
        <strong>Estimated Delivery Date:</strong>
        {{ $order->shipment->delivery_date }}<br>
    </div>

    {{-- Product Summary --}}
    <div class="product-summary">
        <h4>Products</h4>
        @foreach($order->orderDetails as $item)
        <div class="product-item">
            <div>{{ $item->product->product_name }} (x{{ $item->quantity }})</div>
            <div>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
        </div>
        @endforeach

        <div class="total">Subtotal: Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
        <div class="total">Shipping: Rp{{ number_format($order->shipment->shipping_cost ?? 0, 0, ',', '.') }}</div>
        <div class="total" style="font-size: 1.1rem;">
            Total: Rp{{ number_format($order->total_price + ($order->shipment->shipping_cost ?? 0), 0, ',', '.') }}
        </div>
    </div>
</div>

@endsection
