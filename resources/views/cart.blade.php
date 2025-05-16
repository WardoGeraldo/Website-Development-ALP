@extends('base.base')

@section('content')
<div class="container mt-5 mb-5">
    <h4 class="mb-4 fw-bold"><i class="bi bi-cart4"></i> My Cart</h4>

    @if(!empty($cart) && count($cart) > 0)
        <form action="{{ route('cart.bulkUpdate') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Name</th>
                            <th>Price</th>
                            <th style="width: 100px;">Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($cart as $id => $item)
                            @php
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            @endphp
                            <tr>
                                <td><input type="checkbox" name="selected_items[]" value="{{ $id }}"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm">
                                </td>
                                <td>Rp{{ number_format($itemTotal, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <h5>Total: Rp{{ number_format($total, 0, ',', '.') }}</h5>
                    <button type="submit" class="btn btn-outline-primary btn-sm mt-2">Update Quantity</button>
                </div>
                <button type="submit" formaction="{{ route('cart.checkout') }}" class="btn btn-primary">Checkout</button>
            </div>
        </form>
    @else
        <div class="alert alert-info">Your cart is empty.</div>
    @endif
</div>

<script>
    document.getElementById('selectAll')?.addEventListener('change', function () {
        document.querySelectorAll('input[type="checkbox"][name="selected_items[]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
