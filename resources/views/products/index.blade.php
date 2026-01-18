@extends('layouts.myapp')

@section('title', 'Products Page')

@section('content')
    <h1>Product Lists</h1>


    @if (session('success'))
        <div style="color: green; padding: 10px; background: #d4edda;">
            {{ session('success') }}
        </div>
    @endif


    <a href="{{ route('products.create') }}"><button>Add Product</button></a>
    <a href="{{ route('categories.index') }}"><button>Manage Category</button></a>


    {{-- SEARCH FORM --}}
    <div style="margin-top: 20px">
        <form action="/products" method="GET">
            <div>
                <label for="">Name:</label>
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">

            </div>

            {{-- Min price --}}
            <div>
                <label>Min Price:</label>
                <input type="number" name="min_price" placeholder="Min" step="0.01" value="{{ request('min_price') }}">
            </div>

            {{-- Max price --}}
            <div>
                <label>Max Price:</label>
                <input type="number" name="max_price" placeholder="Max" step="0.01" value="{{ request('max_price') }}">
            </div>

            {{-- Sort by --}}
            <div>
                <label>Sort By:</label>
                <select name="sort_by">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Added
                    </option>
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>

            {{-- Sort order --}}
            <div>
                <label>Order:</label>
                <select name="sort_order">
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>

            <button type="submit">Search</button>
            @if (request(['search', 'min_price', 'max_price', 'sort_by', 'sort_order']))
                <a href="/products">Clear</a>
            @endif
        </form>
    </div>


    <ul>
        @foreach ($products as $product)
            <li>
                {{-- {{ $loop->iteration }}  --}}
                {{ $product->name }}
                <a href="/products/{{ $product->id }}">
                    <button>Show Info</button>
                </a>
            </li>
        @endforeach
    </ul>


    {{-- ADD PAGINATION LINKS HERE! --}}
    <div>
        {{ $products->links() }}
    </div>



@endsection
