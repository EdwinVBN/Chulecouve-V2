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
            {{-- @guest
            <button id="login">login</button>
            @endguest
            @auth
            <form action="{{ route('logout.submit') }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
            @endauth --}}

            @if (Auth::check())
                <form action="{{ route('logout.submit') }}" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a id="login">Login</a>
            @endif



            <a href="">Profiel</a>
            <a href="">Zoek</a>
        </article>    
    </header>
    <script src="{{ asset('js/modal.js') }}" defer></script>
</body>
</html>