@extends('layouts.myapp')
@section('title', 'Product Page')
@section('content')
    <h1>Product Information</h1>

    <ul>
        <li>
            Category: {{ $product->category->name }}
        </li>
        <li>
            Product ID: {{ $product->id }}
        </li>
        <li>
            @if ($product->image)
                Image: <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    style="width: 100px; height: 100px; object-fit: cover;">
            @else
                Image: No image available
            @endif
        </li>
        <li>
            Name: {{ $product->name }}
        </li>
        <li>
            Price: ${{ $product->price }}
        </li>
        <li>
            Stock: {{ $product->stock }} pieces
        </li>
    </ul>
    <a href="{{ route('products.index') }}"><button>Back</button></a>

    <a href="{{ route('products.edit', $product->id) }}"><button>Edit</button></a>

    @if (Auth::user()->isAdmin())
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    @endif

@endsection
