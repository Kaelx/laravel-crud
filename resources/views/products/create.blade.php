@extends('layouts.myapp')

@section('title', 'create')

@section('content')

    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- IMPORTANT: Laravel's CSRF protection --}}

        <div>
            <label>Product Name:</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Product Category:</label>
            <select name="category_id">
                <option value="" disabled selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="{{ old('price') }}">
            @error('price')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Stock:</label>
            <input type="number" name="stock" value="{{ old('stock') }}">
            @error('stock')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*">
            @error('image')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Create Product</button>
        <a href="{{ route('products.index') }}"><button type="button">Cancel</button></a>
    </form>

@endsection
