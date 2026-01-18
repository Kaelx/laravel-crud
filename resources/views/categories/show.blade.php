@extends('layouts.myapp')
@section('title', 'Categories')
@section('content')
    <h1>Category Details</h1>
    <ul>
        <li><strong>Name:</strong> {{ $category->name }}</li>
        <li><strong>Description:</strong> {{ $category->description }}</li>
    </ul>
    <a href="{{ route('categories.index') }}"><button>Back</button></a>
    <a href="{{ route('categories.edit', $category->id) }}"><button>Edit</button></a>

    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
    </form>

@endsection
