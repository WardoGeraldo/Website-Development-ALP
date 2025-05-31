@extends('base.base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #f9f9f9;
        color: #333;
        transition: background 0.3s ease, color 0.3s ease;
    }
    
    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap');
    
    .cart-header {
        text-align: center;
        padding: 4rem 1rem 3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        background: linear-gradient(to bottom, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 100%);
    }
    
    .cart-header h2 {
        font-size: 3rem;
        letter-spacing: 4px;
        margin-bottom: 0.8rem;
        font-weight: 700;
        position: relative;
        display: inline-block;
        font-family: 'Playfair Display', serif;
        text-transform: uppercase;
        color: #d4af37;
    }
    
    .cart-header h2::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #d4af37, transparent);
    }

    .cart-icon {
        width: 36px;
        height: 36px;
        vertical-align: middle;
        margin-right: 8px;
        padding-bottom: 8px;
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 0 3px rgba(212, 175, 55, 0.6));
    }

    .cart-header h2:hover .cart-icon {
        transform: scale(1.3) rotate(5deg);
    }
    
    .back-button {
        display: block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
        padding: 10px 20px;
        position: absolute;
        top: 10px;
        left: 20px;
        transition: all 0.3s ease;
        letter-spacing: 1px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    body.dark-mode .back-button {
        color: #e0e0e0;
        background-color: rgba(0, 0, 0, 0.3);
        border-color: rgba(212, 175, 55, 0.3);
    }
    
    .back-button b {
        position: relative;
        padding-bottom: 2px;
        font-family: 'Montserrat', sans-serif;
    }
    
    .back-button b::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background: #d4af37;
        transition: width 0.3s ease;
    }
    
    .back-button:hover {
        color: #d4af37;
        background-color: rgba(212, 175, 55, 0.05);
    }
    
    .back-button:hover b::after {
        width: 100%;
    }

    .cart-grid {
        max-width: 1100px;
        margin: auto;
        padding: 0 2rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        gap: 1.5rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .cart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #d4af37, transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .cart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }
    
    .cart-card:hover::before {
        opacity: 1;
    }

    body.dark-mode .cart-card {
        background: #1e1e1e;
        color: #f5f5f5;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 175, 55, 0.1);
    }

    .cart-card img {
        width: 90px;
        height: 90px;
        border-radius: 0.8rem;
        object-fit: cover;
        flex-shrink: 0;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
        margin-right: 18px;
    }
    
    .cart-card:hover img {
        transform: scale(1.05);
    }

    body.dark-mode .cart-card img {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .cart-checkbox {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        cursor: pointer;
        accent-color: #d4af37;
    }

    .cart-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 10px;
    }

    .cart-info h5 {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
        transition: color 0.3s ease;
        font-family: 'Playfair Display', serif;
    }
    
    .cart-card:hover .cart-info h5 {
        color: #d4af37;
    }

    body.dark-mode .cart-info h5 {
        color: #ffffff;
    }

    .cart-info .text-muted {
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
        font-family: 'Montserrat', sans-serif;
        color: #777 !important;
    }
    
    body.dark-mode .cart-info .text-muted {
        color: #bbb !important;
    }

    .cart-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cart-actions form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cart-actions input[type="number"] {
        width: 70px;
        padding: 0.4rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }
    
    body.dark-mode .cart-actions input[type="number"] {
        background: #333;
        color: #fff;
        border-color: #555;
    }

    .btn-update {
        background: #000;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem;
        width: 40px;
        height: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-update:hover {
        background: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-remove {
        background: transparent;
        border: none;
        color: #ccc;
        font-size: 1.4rem;
        cursor: pointer;
        padding: 0;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .btn-remove:hover {
        color: #e76767;
        background-color: rgba(231, 103, 103, 0.1);
        transform: rotate(90deg);
    }

    .checkout-section {
        max-width: 1100px;
        margin: 0 auto 5rem;
        padding: 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }
    
    body.dark-mode .checkout-section {
        background: #1e1e1e;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 175, 55, 0.1);
    }

    .promo-section {
        margin-bottom: 2rem;
    }

    .promo-section label {
        display: block;
        margin-bottom: 0.8rem;
        font-weight: 600;
        color: #555;
        font-family: 'Montserrat', sans-serif;
    }
    
    body.dark-mode .promo-section label {
        color: #e0e0e0;
    }

    .promo-input-group {
        display: flex;
        gap: 0.8rem;
        width: 100%;
        max-width: 400px;
    }

    .promo-input-group input[type="text"] {
        flex-grow: 1;
        padding: 0.8rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.8rem;
        font-size: 1rem;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }
    
    .promo-input-group input[type="text"]:focus {
        border-color: #d4af37;
        outline: none;
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }
    
    body.dark-mode .promo-input-group input[type="text"] {
        background: #333;
        color: #fff;
        border-color: #555;
    }

    .apply-promo-btn {
        background: #000;
        color: white;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 0.8rem;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .apply-promo-btn:hover {
        background: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
    }

    .price-summary {
        background: #f9f9f9;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }
    
    body.dark-mode .price-summary {
        background: #333;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 175, 55, 0.1);
    }

    .price-summary h5,
    .price-summary h6,
    .price-summary h4 {
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 1px;
    }

    .price-summary hr {
        border-color: rgba(212, 175, 55, 0.2);
        margin: 1rem 0;
    }

    .checkout-btn {
        background: #000;
        color: white;
        border: none;
        border-radius: 0.8rem;
        padding: 1rem 2rem;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 1.5rem;
    }

    .checkout-btn:hover {
        background: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
    }
    
    .notification {
        margin-top: 12px;
        padding: 8px 12px;
        border-radius: 6px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
    }
    
    .notification.success {
        color: #0f5132;
        background-color: #d1e7dd;
        border: 1px solid #badbcc;
    }
    
    .notification.error {
        color: #842029;
        background-color: #f8d7da;
        border: 1px solid #f5c2c7;
    }
    
    body.dark-mode .notification.success {
        background-color: rgba(209, 231, 221, 0.2);
        color: #badbcc;
    }
    
    body.dark-mode .notification.error {
        background-color: rgba(248, 215, 218, 0.2);
        color: #f5c2c7;
    }
</style>

<div class="cart-header">
    <div class="back-button" onclick="window.location.href='{{ route('store.show') }}'">
        <b>← Back To Store</b>
    </div>
    <h2>
        My Cart
        <span class="cart-icon">🛒</span>
    </h2>
</div>

@php
    $total = 0; // Initialize the total variable before use
@endphp

<div class="cart-grid">
    @forelse($cartItems as $item)
        @php
            $itemTotal = $item->product->price * $item->product_qty;
        @endphp

        <div class="cart-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="cart-checkbox"
                    name="selected[]" value="{{ $item->cart_id }}"
                    data-price="{{ $itemTotal }}">
                    @php
                        $imageDir = public_path("images/products/{$item->product->product_id}");
                        $imageUrl = asset('fotoBaju.jpg'); // fallback

                        if (File::exists($imageDir)) {
                            $files = File::files($imageDir);
                            $image = collect($files)->first(function ($file) {
                                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
                            });

                            if ($image) {
                                $imageUrl = asset("images/products/{$item->product->product_id}/" . $image->getFilename());
                            }
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" style="width: 100px;">
                    <div class="cart-info">
                    <h5>{{ $item->product->name }}</h5>
                    <div class="text-muted">Size: {{ $item->product_size }}</div>
                    <div class="text-muted">Price: Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                    <div class="text-muted">Total: Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="cart-actions">
                <form action="{{ route('cart.bulkUpdate') }}" method="POST">
                    @csrf
                    <input type="number" name="quantities[{{ $item->cart_id }}]" value="{{ $item->product_qty }}" min="1">
                    <button type="submit" class="btn-update">✔</button>
                </form>
                <a href="{{ route('cart.remove', $item->cart_id) }}" class="btn-remove">×</a>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div class="alert alert-info">Your cart is empty.</div>
        </div>
    @endforelse
</div>


<div class="checkout-section">
    <div class="row">
        <!-- Promo Code Input -->
        <div class="col-md-6 mb-4">
            <div class="promo-section">
                <label for="promo">Promo Code</label>
                <form method="POST" action="{{ route('cart.applyPromo') }}" class="promo-input-group">
                    @csrf
                    <input type="text" name="promo" placeholder="Enter promo code..." value="{{ old('promo', $promoCode) }}">
                    <button class="apply-promo-btn">Apply</button>
                </form>
                @if(session('success'))
                    <div class="notification success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="notification error">{{ session('error') }}</div>
                @endif
            </div>
        </div>

        <!-- Price Summary -->
        <div class="col-md-6">
            <div class="price-summary">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="mb-0">Subtotal:</h5>
                    <h5 class="mb-0">Rp<span class="subtotal-value">0</span></h5>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="mb-0 text-success">Promo Discount:</h6>
                    <h6 class="mb-0 text-success">-Rp<span class="discount-value">0</span></h6>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Total:</h4>
                    <h4 class="mb-0 text-primary">Rp<span class="total-value">0</span></h4>
                </div>
                <div class="text-end">
                    <button class="checkout-btn" id="checkout-btn">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Checkout Form -->
<form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST" style="display: none;">
    @csrf
    <div id="selected-inputs"></div>
</form>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif
<script>
AOS.init({
    duration: 800,
    easing: 'ease-out',
    once: true
});

const promoCode = "{{ $promoCode }}";
const discountRate = {{ $discountRate }};

function updateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.cart-checkbox:checked').forEach(checkbox => {
        subtotal += parseFloat(checkbox.getAttribute('data-price'));
    });

    const discount = subtotal * discountRate;
    const total = subtotal - discount;

    document.querySelector('.subtotal-value').textContent = formatRupiah(subtotal);
    document.querySelector('.discount-value').textContent = formatRupiah(discount);
    document.querySelector('.total-value').textContent = formatRupiah(total);
}

function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

document.querySelectorAll('.cart-checkbox').forEach(cb => {
    cb.addEventListener('change', updateTotals);
});

updateTotals();
</script>

<script>
document.getElementById('checkout-btn').addEventListener('click', function () {
    const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
    const selectedInputsContainer = document.getElementById('selected-inputs');
    selectedInputsContainer.innerHTML = '';

    if (selectedCheckboxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Items Selected',
            text: 'Please select at least one item to checkout.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }

    selectedCheckboxes.forEach(function (checkbox) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'selected[]';
        hiddenInput.value = checkbox.value;
        selectedInputsContainer.appendChild(hiddenInput);
    });

    Swal.fire({
        title: 'Proceed to Checkout?',
        text: 'Are you sure you want to checkout the selected items?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Checkout'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('checkout-form').submit();
        }
    });
});
</script>
@endsection