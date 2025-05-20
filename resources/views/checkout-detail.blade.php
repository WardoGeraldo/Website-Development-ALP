@extends('base.base')

@section('content')
<style>
    .checkout-container {
        max-width: 800px;
        margin: auto;
        padding: 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        font-family: 'Cormorant', serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-family: 'Cormorant', serif;

    }

    .user-info, .order-summary, .promo-section {
        margin-bottom: 2rem;
        font-family: 'Cormorant', serif;
    }

    .user-info label,
    .promo-section label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
        font-family: 'Cormorant', serif;
    }

    .user-info input,
    .promo-section input {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: 'Cormorant', serif;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
        font-family: 'Cormorant', serif;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .total {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
        margin-top: 1rem;
        font-family: 'Cormorant', serif;
    }

    .dark-mode .checkout-container {
        background-color: black;
    }
</style>

<div class="checkout-container">
    <h2>Checkout Details</h2>

    <!-- User Info -->
    <div class="user-info">
        <label>Email</label>
        <input type="email" value="{{ $user['email'] ?? '' }}" readonly>

        <label>Address</label>
        <input type="text" value="{{ $user['address'] ?? '' }}" readonly>

        <label>Contact Number</label>
        <input type="text" value="{{ $user['contact'] ?? '' }}" readonly>
    </div>

    <!-- Order Summary -->
    <div class="order-summary">
        <h4>Order Summary</h4>
        @foreach($orders as $order)
            <div class="order-item">
                <div>{{ $order['name'] }} (x{{ $order['quantity'] }})</div>
                <div>Rp{{ number_format($order['price'] * $order['quantity'], 0, ',', '.') }}</div>
            </div>
        @endforeach
        <div class="total" id="orderTotal">
            <div>Subtotal: Rp{{ number_format($total, 0, ',', '.') }}</div>

            @if(isset($promoCode) && $discountAmount > 0)
                <div style="color: green;">
                    Promo Code ({{ $promoCode }}): -Rp{{ number_format($discountAmount, 0, ',', '.') }}
                </div>
                <hr>
                <div style="font-size: 1.3rem; font-weight: bold;">
                    Total after discount: Rp{{ number_format($finalTotal, 0, ',', '.') }}
                </div>
            @else
                <div style="font-size: 1.3rem; font-weight: bold;">
                    Total: Rp{{ number_format($total, 0, ',', '.') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
