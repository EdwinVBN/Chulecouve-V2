<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoBo</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body" style="color: white;">
    <header>
        <article id="header-logo">
            <a href="/">
                <img src="{{asset('img/HOBO_Beeldmerk.png')}}">    
            </a>
        </article>
        <article id="header-right">
            <a href="{{route('genres')}}">Genres</a>
            <a href="{{route('customer-service')}}">Customer Service</a>
            @if (Auth::check())
                @if (Auth::user()->AboID == 5 || Auth::user()->AboID == 4)
                <a href="{{ route('admin.manageSeries') }}">Manage</a>
                @endif
                @if (Auth::user()->AboID == 4)
                <a href="{{ route('admin') }}">Admin</a>
                @endif
            @endif
            @if (!Auth::check())
            <a href="{{ route('register') }}">Register</a>
            @endif
            @if (Auth::check())
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endif
            @if (Auth::check())
            <a href="{{ route('profiel', Auth::user()->KlantNr) }}">Profiel</a>
            @endif
            <a href="{{ route('search') }}">Zoek</a>
        </article>    
    </header>
</body>
</html>