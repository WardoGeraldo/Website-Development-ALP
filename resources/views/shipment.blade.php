{{-- @extends('base.base')

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

    .progress-bar {
        display: flex;
        justify-content: space-between;
        margin: 1rem 0;
        position: relative;
    }

    .progress-bar::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 5%;
        right: 5%;
        height: 4px;
        background: #eee;
        z-index: 1;
    }

    .progress-step {
        background: #ccc;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        z-index: 2;
        position: relative;
        text-align: center;
        line-height: 20px;
        font-size: 12px;
    }

    .progress-step.active {
        background: #000;
        color: #fff;
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        color: #555;
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

    <div class="progress-bar">
        <div class="progress-step {{ $order->shipment->status >= 1 ? 'active' : '' }}">1</div>
        <div class="progress-step {{ $order->shipment->status >= 2 ? 'active' : '' }}">2</div>
        <div class="progress-step {{ $order->shipment->status >= 3 ? 'active' : '' }}">3</div>
        <div class="progress-step {{ $order->shipment->status == 4 ? 'active' : '' }}">4</div>
    </div>
    <div class="progress-labels">
        <div>Ordered</div>
        <div>Dispatched</div>
        <div>In Transit</div>
        <div>Delivered</div>
    </div>

    <div class="timeline">
        @foreach($order->shipment->logs as $log)
        <div class="timeline-entry">
            <strong>{{ $log->description }}</strong>
            <time>{{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y H:i') }}</time>
        </div>
        @endforeach
    </div>

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
        <div class="total" style="font-size: 1.1rem;">Total: Rp{{ number_format($order->total_price + ($order->shipment->shipping_cost ?? 0), 0, ',', '.') }}</div>
    </div>
</div>
@endsection --}}
