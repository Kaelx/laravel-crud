@extends('layouts.myapp')

@section('title', 'About Page')

@section('content')
    <h1>About Us</h1>
    <p>This is the about page of the application.</p>

    <p>Company: {{ $company }}</p>
    <p>Founded: {{ $founded }}</p>

@endsection
