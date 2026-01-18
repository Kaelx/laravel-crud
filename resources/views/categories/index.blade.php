@extends('layouts.myapp')
@section('title', 'Categories')
@section('content')
    <h1>Categories</h1>

    <a href="{{ route('categories.create') }}"><button>Add Category</button></a>
    <a href="{{ route('products.index') }}"><button>Back</button></a>
    <ul>
        @foreach ($categories as $category)
            <li>{{ $category->name }} <a href="{{ route('categories.show', $category->id) }}"><button>View</button></a></li>
        @endforeach
    </ul>
@endsection
