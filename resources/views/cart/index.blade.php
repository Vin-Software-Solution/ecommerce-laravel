@extends('layouts.app')

@section('content')
<h1>Your Cart</h1>

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
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>$ {{ number_format($item->product->price, 2) }}</td>
                <td>$ {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td colspan="2" class="fw-bold">
                    $ {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
@endif
@endsection
