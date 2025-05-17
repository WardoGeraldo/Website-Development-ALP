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
        font-size: 20px;
    }
</style>
@extends('base.base')

@section('content')
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
        @foreach($cart as $id => $item)
            @php
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
            @endphp

            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between p-3 shadow-sm rounded-4 bg-white">
                    {{-- Checkbox + Image --}}
                    <div class="d-flex align-items-center me-3">
                        <input type="checkbox" class="form-check-input me-3" name="selected[]" value="{{ $id }}">
                        {{-- @if(isset($item['image'])) --}}
                        <img src="{{ asset('fotoBaju.jpg') }}" alt="{{ $item['name'] }}"
                        class="rounded-3" style="width: 70px; height: 70px; object-fit: cover;">
                    </div>

                    {{-- Product Info --}}
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb- fw-semibold">{{ $item['name'] }}</h5>
                        <div class="text-muted">Size: Large</div>
                        <div class="text-muted">Price: Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                        <div class="text-muted">Total: Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                    </div>

                    {{-- Quantity Input --}}
                    <div class="me-3">
                        <form action="{{ route('cart.bulkUpdate', 0) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1"
                                   class="form-control form-control-sm me-2" style="width: 60px;">
                            <button type="submit" class="btn btn-outline-success btn-sm" title="Update Quantity">✔</button>
                        </form>
                    </div>

                    {{-- Remove Button --}}
                    <div>
                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-outline-danger btn-sm">×</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Total Price and Checkout --}}
    <div class="mt-5 p-4 bg-light rounded-4 shadow-sm text-end">
        <h5 class="fw-bold">Total: Rp{{ number_format($total, 0, ',', '.') }}</h5>
        <button class="btn btn-primary mt-3 px-4 py-2" id="checkout-btn">Checkout</button>
    </div>

    {{-- Hidden form for selected checkout --}}
    <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST" style="display: none;">
        @csrf
        <div id="selected-inputs"></div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- MISAL UPDATE KALAU SUCCESS AMBIL ICON INI TERUS KE function bulkUpdate di controller, makanya text session nya sesuai --}}
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
document.getElementById('checkout-btn').addEventListener('click', function () {
    const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
    const selectedInputsContainer = document.getElementById('selected-inputs');
    selectedInputsContainer.innerHTML = ''; // Clear old inputs

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
