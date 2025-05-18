@extends('base.base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    .back-button {
        display: block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
        font-weight: 500;
        font-size: 18px;
    }

    .cart-card {
        transition: box-shadow 0.3s ease;
    }

    .cart-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .promo-section {
        display: block; /* no need for flex or align-items */
        margin-bottom: 1.5rem;
    }

    .promo-input-group {
        display: flex;
        gap: 0.5rem;
        width: 100%;
        max-width: 400px;
    }

    .promo-input-group input[type="text"] {
        flex-grow: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .apply-promo-btn {
        background: #111;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
    }

    .apply-promo-btn:hover {
        background: #e76767;
    }

    .price-summary {
        max-width: none; /* allow full width inside col-6 */
        margin-left: 0;
    }

    .price-summary h5,
    .price-summary h6,
    .price-summary h4 {
        margin: 0.25rem 0;
    }

    .checkout-btn {
        margin-top: 1.5rem;
        padding: 0.6rem 2rem;
        font-size: 16px;
        font-weight: 500;
        border-radius: 8px;
        background: black;
        color: white;
    }

    .checkout-btn:hover {
        background-color: #e76767;
    }
</style>

<div class="container py-5">
    <div class="back-button" onclick="window.location.href='{{ route('store.show') }}'">
        ← Back To Store
    </div>
    <h2 class="mb-4 fw-bold text-center">My Cart 🛒</h2>

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

    @php $total = 0; @endphp
    <div class="row g-4">
        @forelse($cart as $id => $item)
            @php
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
            @endphp

            <div class="col-12" data-aos="fade-up">
                <div class="cart-card d-flex align-items-center justify-content-between p-3 rounded-4 bg-white border">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-3 cart-checkbox"
                            name="selected[]" value="{{ $id }}"
                            data-price="{{ $itemTotal }}">
                        <img src="{{ asset('fotoBaju.jpg') }}" alt="{{ $item['name'] }}"
                             class="rounded-3 me-3" style="width: 70px; height: 70px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1 fw-semibold">{{ $item['name'] }}</h5>
                            <div class="text-muted small">Size: Large</div>
                            <div class="text-muted small">Price: Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                            <div class="text-muted small">Total: Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <form action="{{ route('cart.bulkUpdate', 0) }}" method="POST" class="d-flex me-3">
                            @csrf
                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1"
                                   class="form-control form-control-sm me-2" style="width: 60px;">
                            <button type="submit" class="btn btn-outline-success btn-sm">✔</button>
                        </form>
                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-outline-danger btn-sm">×</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">Your cart is empty.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-5 p-4 bg-light rounded-4 shadow-sm">
        <div class="row">
            <!-- Promo Code Input -->
            <div class="col-md-6 mb-4">
                <label for="promo">Promo Code</label>
                <form method="POST" action="{{ route('cart.applyPromo') }}" class="promo-input-group">
                    @csrf
                    <input type="text" name="promo" placeholder="Enter promo code..." value="{{ old('promo', $promoCode) }}">
                    <button class="apply-promo-btn">Apply</button>
                </form>
                @if(session('success'))
                    <div style="color: green; margin-top: 10px;">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div style="color: red; margin-top: 10px;">{{ session('error') }}</div>
                @endif
            </div>

        <!-- Price Summary Full Width -->
        <div class="col-md-6">
            <div class="price-summary bg-white p-4 rounded-4 shadow-sm w-100">
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
                <div class="text-end mt-4">
                    <button class="btn btn-primary checkout-btn" id="checkout-btn">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Checkout Form -->
    <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST" style="display: none;">
        @csrf
        <div id="selected-inputs"></div>
    </form>
</div>

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
AOS.init();
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
    document.querySelector('.discount-value').textContent = discount > 0 ? `-Rp${formatRupiah(discount)}` : '-Rp0';
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