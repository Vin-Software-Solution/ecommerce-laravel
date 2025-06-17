@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
        @endif
    </div>
    <div class="col-md-6">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <p class="fw-bold">$ {{ number_format($product->price, 2) }}</p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center">
            @csrf
            <input type="number" name="quantity" value="1" min="1" class="form-control me-2" style="width: 80px;">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
</div>
@endsection
