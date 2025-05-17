@extends('base.base')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">My Cart</h2>

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

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Price</th>
                    <th style="width: 150px;">Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    @endphp
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="{{ $id }}"></td>
                        <td class="fw-semibold">{{ $item['name'] }}</td>
                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.bulkUpdate', 0) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}"
                                       class="form-control form-control-sm me-2" min="1" style="width: 60px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Update Quantity">
                                    ✔
                                </button>
                            </form>
                        </td>
                        <td>Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger">Remove</a>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">Total:</td>
                    <td colspan="2">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <button class="btn btn-primary px-4 py-2" id="checkout-btn">Checkout</button>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('checkout-btn').addEventListener('click', function () {
            Swal.fire({
                title: 'Proceed to Checkout?',
                text: 'Are you sure you want to checkout and clear your cart?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Checkout'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('cart.checkout') }}";
                }
            });
        });

        // Show success message after checkout
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        @endif
    </script>
@endsection
