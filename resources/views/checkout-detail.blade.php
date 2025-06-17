@extends('base.base')
@section('content')
    <!-- Required CSS Libraries -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    :root {
        --primary: #ffffff;
        --secondary: #000000;
        --accent: #D4AF37;
        --accent-light: #F8F1D5;
        --accent-dark: #9E7C1F;
        --light-gray: #f9f9f9;
        --medium-gray: #e0e0e0;
        --text-primary: #000000;
        --text-secondary: #505050;
        --text-accent: #D4AF37;
        --transition: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Dark mode variable overrides */
    body.dark-mode {
        --primary: #121212;
        --secondary: #f5f5f5;
        --light-gray: #1e1e1e;
        --medium-gray: #333333;
        --text-primary: #f5f5f5;
        --text-secondary: #aaaaaa;
    }

    body,
    html {
        background-color: var(--primary);
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
        overflow-x: hidden;
        cursor: default;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* Pattern Overlay */
    .pattern-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: 1;
    }

    /* Gold accents */
    .gold-accent {
        position: absolute;
        width: 30%;
        height: 30%;
        background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
        filter: blur(20px);
        border-radius: 50%;
        z-index: 0;
        pointer-events: none;
    }

    .gold-accent-1 {
        top: -10%;
        right: 5%;
        animation: float 20s infinite alternate;
    }

    .gold-accent-2 {
        bottom: 10%;
        left: 5%;
        animation: float 25s infinite alternate-reverse;
    }

    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(10px, 15px) rotate(3deg);
        }

        100% {
            transform: translate(-10px, 5px) rotate(-3deg);
        }
    }

    .checkout-wrapper {
        min-height: 100vh;
        background-color: var(--primary);
        padding: 5rem 0 2rem;
        position: relative;
        z-index: 1;
    }
    
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
        padding: 0 2rem;
        position: relative;
        z-index: 2;
    }
    
    .checkout-main {
        background: var(--primary);
        padding: 2rem;
        border-radius: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--medium-gray);
        transition: all 0.4s var(--transition);
        position: relative;
    }

    .checkout-main::before {
        content: '';
        position: absolute;
        top: 10px;
        right: 10px;
        bottom: 10px;
        left: 10px;
        border: 1px solid rgba(212, 175, 55, 0.1);
        transition: all 0.4s var(--transition);
        pointer-events: none;
        z-index: 1;
    }
    
    .checkout-sidebar {
        background: var(--primary);
        padding: 2rem;
        border-radius: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--medium-gray);
        height: fit-content;
        transition: all 0.4s var(--transition);
        position: relative;
    }

    .checkout-sidebar::before {
        content: '';
        position: absolute;
        top: 10px;
        right: 10px;
        bottom: 10px;
        left: 10px;
        border: 1px solid rgba(212, 175, 55, 0.1);
        transition: all 0.4s var(--transition);
        pointer-events: none;
        z-index: 1;
    }
    
    .brand-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
        letter-spacing: 3px;
        color: var(--accent);
    }
    
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--accent);
        padding-bottom: 0.5rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .form-label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--medium-gray);
        border-radius: 0;
        font-size: 1rem;
        font-family: 'Montserrat', sans-serif;
        background: var(--primary);
        color: var(--text-primary);
        transition: all 0.3s var(--transition);
        position: relative;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
    }
    
    .form-input[readonly] {
        background: var(--light-gray);
        color: var(--text-secondary);
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
        border-bottom: 1px solid var(--medium-gray);
        position: relative;
        z-index: 2;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
    
    .item-meta {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 0.5px;
    }
    
    .item-price {
        font-weight: 600;
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        font-family: 'Montserrat', sans-serif;
        color: var(--text-primary);
        position: relative;
        z-index: 2;
    }
    
    .summary-row.discount {
        color: var(--accent);
    }
    
    .summary-row.total {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 0.75rem;
        border-top: 1px solid var(--accent);
        margin-top: 1rem;
        letter-spacing: 1px;
    }
    
    .currency {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-family: 'Montserrat', sans-serif;
    }

    .ship-add {
        color: var(--text-secondary);
    }

    .checkout-btn {
        width: 100%;
        background: var(--secondary);
        color: var(--primary);
        border: none;
        padding: 1rem 1.5rem;
        border-radius: 0;
        font-size: 1rem;
        font-weight: 500;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.4s var(--transition);
        margin-top: 1.5rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--accent);
        transition: all 0.4s var(--transition);
        z-index: -1;
    }

    .checkout-btn:hover {
        color: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .checkout-btn:hover::before {
        left: 0;
    }
    
    /* Dark mode styles */
    .dark-mode .checkout-main,
    .dark-mode .checkout-sidebar {
        background: var(--primary);
        color: var(--text-primary);
        border-color: var(--medium-gray);
    }

    .dark-mode .checkout-main::before,
    .dark-mode .checkout-sidebar::before {
        border-color: rgba(212, 175, 55, 0.2);
    }
    
    .dark-mode .brand-title,
    .dark-mode .section-title,
    .dark-mode .item-name {
        color: var(--accent);
    }
    
    .dark-mode .form-label {
        color: var(--text-secondary);
    }
    
    .dark-mode .form-input {
        background: var(--primary);
        border-color: var(--medium-gray);
        color: var(--text-primary);
    }
    
    .dark-mode .form-input[readonly] {
        background: var(--light-gray);
        color: var(--text-secondary);
    }
    
    .dark-mode .item-meta {
        color: var(--text-secondary);
    }

    .dark-mode .item-price {
        color: var(--text-primary);
    }

    .dark-mode .currency,
    .dark-mode .ship-add {
        color: var(--text-secondary);
    }

    .dark-mode .summary-row {
        color: var(--text-primary);
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

        .checkout-wrapper {
            padding: 4rem 0 1.5rem;
        }

        .brand-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
        }
    }
</style>

<div class="checkout-wrapper">
    <div class="pattern-overlay"></div>
    <div class="gold-accent gold-accent-1"></div>
    <div class="gold-accent gold-accent-2"></div>

    <div class="checkout-container">
    <div class="checkout-main" data-aos="fade-right" data-aos-duration="800">
        <form action="{{ route('cart.processCheckout') }}" method="POST">
            @csrf
            <div class="brand-title">CHECKOUT</div>
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
            <div class="checkout-sidebar" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
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
                    <span id="shipping-address" class="ship-add">Enter shipping address</span>
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
// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: false,
    mirror: true
});

function updateShippingAddress() {
    const address = document.querySelectorAll('.form-input')[3].value;
    const shippingElement = document.getElementById('shipping-address');
    
    if (address.trim() !== '') {
        shippingElement.textContent = address;
    } else {
        shippingElement.textContent = 'Enter shipping address';
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

// Check for saved dark mode preference
document.addEventListener('DOMContentLoaded', function() {
    const savedDarkMode = localStorage.getItem('darkMode');
    if (savedDarkMode === 'true') {
        document.body.classList.add('dark-mode');
    }
});
</script>

@endsection