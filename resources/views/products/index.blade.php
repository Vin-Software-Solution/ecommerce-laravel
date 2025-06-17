@extends('layouts.app')

@section('content')
<h1>Products</h1>
<div class="row">
    @foreach($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-truncate">{{ $product->description }}</p>
                <p class="card-text fw-bold">$ {{ number_format($product->price, 2) }}</p>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-auto">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
