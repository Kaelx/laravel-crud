@extends('layouts.myapp')
@section('title', 'Categories')
@section('content')
    <h1>Add Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger" style="color: red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>


    @endif


    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}">
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description"
                value="{{ old('description', $category->description) }}">
        </div>
        <button type="submit">Save</button>
        <a href="{{ route('categories.index') }}"><button type="button">Cancel</button></a>
    </form>

@endsection
