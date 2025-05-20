@extends('base.base')

@section('content')
<style>
    .history-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        font-family: 'Cormorant', serif;
    }

    .history-entry {
        margin-bottom: 2rem;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 10px;
    }

    .history-entry h4 {
        margin-bottom: 1rem;
        color: #333;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .total {
        text-align: right;
        font-weight: bold;
        margin-top: 1rem;
    }

    .dark-mode .history-container{
        background-color: #121212;
        color: #f0f0f0;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.05);
    }

    .dark-mode .history-entry h4 {
        color: #f0f0f0;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.05);
    }
</style>

<div class="history-container">
    <h2>Order History</h2>

    @if(count($orders) === 0)
        <p>You have no order history yet.</p>
    @else
        @foreach(array_reverse($orders) as $order)
            <div class="history-entry">
                <h4>Order on {{ \Carbon\Carbon::parse($order['timestamp'])->format('F j, Y H:i') }}</h4>

                @foreach($order['orders'] as $item)
                    <div class="order-item">
                        <div>{{ $item['name'] }} (x{{ $item['quantity'] }})</div>
                        <div>Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                    </div>
                @endforeach

                <div class="total">Subtotal: Rp{{ number_format($order['total'], 0, ',', '.') }}</div>

                @if($order['discount'] > 0)
                    <div class="total" style="color: green;">
                        Promo ({{ $order['promo'] }}): -Rp{{ number_format($order['discount'], 0, ',', '.') }}
                    </div>
                @endif

                <div class="total" style="font-size: 1.2rem;">
                    Final Total: Rp{{ number_format($order['final_total'], 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
