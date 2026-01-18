@extends('layouts.myapp')

@section('title', 'Home Page')

@section('content')
    <h1>Welcome to the Home Page</h1>
    <p>This is the home page of the application.</p>

    <a href="{{ route('products.index') }}"><button>Goto Products</button></a>

@endsection
