
@extends('base.base')
@section('content')
<style>
    .checkout-wrapper {
        min-height: 100vh;
        background: #f8f9fa;
        padding: 2rem 0;
    }
    
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
        padding: 0 2rem;
    }
    
    .checkout-main {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    
    .checkout-sidebar {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        height: fit-content;
    }
    
    .brand-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
        letter-spacing: 2px;
        color: #1a1a1a;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #1a1a1a;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #4a4a4a;
        font-size: 0.9rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        background: #fafafa;
        transition: border-color 0.2s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #007bff;
        background: white;
    }
    
    .form-input[readonly] {
        background: #f8f9fa;
        color: #6c757d;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #1a1a1a;
    }
    
    .item-meta {
        font-size: 0.9rem;
        color: #666;
    }
    
    .item-price {
        font-weight: 600;
        color: #1a1a1a;
    }
    
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }
    
    .summary-row.discount {
        color: #28a745;
    }
    
    .summary-row.total {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 0.75rem;
        border-top: 2px solid #f0f0f0;
        margin-top: 1rem;
    }
    
    .currency {
        font-weight: 600;
        color: #666;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 0 1rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .dark-mode .checkout-wrapper {
        background: #1a1a1a;
    }
    
    .dark-mode .ship-add{
        color: white;
    }
    .dark-mode .currency{
        color: white;
    }
    .dark-mode .checkout-main,
    .dark-mode .checkout-sidebar {
        background: #2d2d2d;
        color: white;
    }
    
    .dark-mode .brand-title,
    .dark-mode .section-title,
    .dark-mode .item-name {
        color: white;
    }
    
    .dark-mode .form-label {
        color: white;
    }
    

    .dark-mode .form-input {
        background: #3a3a3a;
        border-color: #4a4a4a;
        color: white;
    }
    
    .dark-mode .form-input[readonly] {
        background: #2a2a2a;
        color: #999;
    }
    
    .dark-mode .promo-section {
        background: #3a3a3a;
    }
    
    .dark-mode .item-meta {
        color: white;
    }
    .dark-mode .item-price {
        color: white;
    }
    .checkout-btn {
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease;
        margin-top: 1.5rem;
    }
    
    .checkout-btn:hover {
        background: #0056b3;
    
    }
</style>

<div class="checkout-wrapper">
    <div class="checkout-container">
    <div class="checkout-main">
        <form action="{{ route('cart.processCheckout') }}" method="POST">
            @csrf
            <div class="brand-title"></div>
                <!-- Contact Section -->
                <div class="section-title">Contact</div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ $user['email'] ?? '' }}">
                </div>
                
                <!-- Delivery Section -->
                <div class="section-title">Delivery</div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-input" value="{{ old('first_name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-input" value="{{ old('last_name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Address (Ship to)</label>
                    <input type="text" name="address_line1" class="form-input" value="{{ old('address_line1') }}" onchange="updateShippingAddress()">
                </div>

                <div class="form-group">
                    <label class="form-label">Apartment, suite, etc.(Optional)</label>
                    <input type="text" name="address_line2" class="form-input" value="{{ old('address_line2') }}" onchange="updateShippingAddress()">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-input" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" name="zip_code" class="form-input" value="{{ old('zip_code') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user['contact'] ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Shipment Date</label>
                    <input type="date" name="shipment_date" class="form-input" value="{{ old('shipment_date', now()->toDateString()) }}">
                </div>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="checkout-sidebar">
                <!-- Order Items -->
                @foreach($orders as $order)
                <div class="order-item">
                    <div class="item-details">
                        <div class="item-name">{{ $order['name'] }}</div>
                        <div class="item-meta">Qty: {{ $order['quantity'] }}</div>
                    </div>
                    <div class="item-price">Rp{{ number_format($order['price'] * $order['quantity'], 0, ',', '.') }}</div>
                </div>
                @endforeach
                
                <!-- Order Summary -->
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                @if(isset($promoCode) && $discountAmount > 0)
                <div class="summary-row discount">
                    <span>Discount ({{ $promoCode }})</span>
                    <span>-Rp{{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="summary-row">
                    <span>Shipping</span>
                    <span id="shipping-address">Enter shipping address</span>
                </div>
                
                <div class="summary-row total">
                    <span>Total</span>
                    <span>
                        <span class="currency">IDR</span> 
                        Rp{{ number_format(isset($finalTotal) ? $finalTotal : $total, 0, ',', '.') }}
                    </span>
                </div>
            <button type="submit" class="checkout-btn">Complete Order</button>
        </form>
    </div>
    </div>
</div>


<script>
function updateShippingAddress() {
    const address = document.querySelectorAll('.form-input')[3].value;
    const shippingElement = document.getElementById('shipping-address');
    
    if (address.trim() !== '') {
        shippingElement.textContent = address;
        // shippingElement.style.color = '#1a1a1a';
    } else {
        shippingElement.textContent = 'Enter shipping address';
        // shippingElement.style.color = '#666';
    }
}

// Update shipping address on page load if address is pre-filled
window.addEventListener('DOMContentLoaded', function() {
    updateShippingAddress();
});

function confirmCheckout() {
    // Get form values
    const email = document.querySelector('input[type="email"]').value;
    const firstName = document.querySelectorAll('.form-input')[1].value;
    const lastName = document.querySelectorAll('.form-input')[2].value;
    const address = document.querySelectorAll('.form-input')[3].value;
    const phone = document.querySelector('input[type="tel"]').value;
    
    // Basic validation
    if (!email || !lastName || !address || !phone) {
        alert('Please fill in all required fields (Email, Last name, Address, Phone)');
        return;
    }
    
    // Show confirmation dialog
    const confirmMessage = `Confirm your order:\n\nEmail: ${email}\nAddress: ${address}\n\nProceed with checkout?`;
    
    if (confirm(confirmMessage)) {
        // Here you would typically submit to your backend
        alert('Order confirmed! You will be redirected to payment.');
        // window.location.href = '/payment'; // Redirect to payment page
    }
}
</script>

@endsection