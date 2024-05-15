@php
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body>
    <header>
        <article id="header-logo">
            <a href="/">
                <img src="img/HOBO_Beeldmerk.png">    
            </a>
        </article>
        <article id="header-right">
            @auth
            <button id="login">login</button>
            @endauth

            {{-- @if (Auth::check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <button id="login">Login</button>
            @endif --}}



            <a href="">Profiel</a>
            <a href="">Zoek</a>
        </article>    
    </header>
    <script src="{{ asset('js/modal.js') }}" defer></script>
</body>
</html>