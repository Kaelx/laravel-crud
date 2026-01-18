<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<nav>
    @include('layouts.nav')
</nav>

<body>
    @yield('content')
</body>

<footer>
    <p>&copy; {{ date('Y') }} My App. All rights reserved.</p>
</footer>

</html>
