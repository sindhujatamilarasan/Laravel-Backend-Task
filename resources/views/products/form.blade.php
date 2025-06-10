@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header text-center">
            <h4 class="mb-0">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}" method="POST">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="form-group mb-3">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $product->name ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="quantity">Product Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                           value="{{ old('quantity', $product->quantity ?? '') }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($product) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
