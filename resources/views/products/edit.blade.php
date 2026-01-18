@extends('layouts.myapp')

@section('title', 'Edit')

@section('content')

    <h1>Edit Product</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Laravel method spoofing for PUT request --}}

        <div>
            <label>Product Name:</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}">
        </div>
        <div>
            <label>Category:</label>
            <select name="category_id" required>
                <option value="" disabled>Select a category</option>
                @foreach ($category as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}">
        </div>

        <div>
            <label>Stock:</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
        </div>

        <div>
            <div>
                <label>Current Image:</label>
                @if ($product->image)
                    <div>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                @else
                    <p>No image</p>
                @endif
            </div>
            <div>
                <label>Upload New Image (optional):</label>
                <input type="file" name="image" accept="image/*">
                <small>Leave empty to keep current image</small>
            </div>
        </div>

        <button type="submit">Update Product</button>
        <a href="{{ route('products.index') }}"><button type="button">Cancel</button></a>
    </form>

@endsection
