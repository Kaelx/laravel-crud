<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div>
        <div>You are logged in!</div>
    </div>

    <a href="{{ route('products.index') }}"><button>Click Me</button></a>
</x-app-layout>
