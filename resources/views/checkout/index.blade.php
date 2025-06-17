@extends('layouts.app')

@section('content')
<h1>Checkout</h1>

@if($cartItems->isEmpty())
    <p>Your cart is empty.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>$ {{ number_format($item->product->price, 2) }}</td>
                <td>$ {{ number_format($item->product->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="fw-bold">
                    $ {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
@endif
@endsection
