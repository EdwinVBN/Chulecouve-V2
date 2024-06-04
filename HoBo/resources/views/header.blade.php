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
            <img id='hamburger' src='{{ asset('img/hamburger.png') }}' onclick="openBar()">
            @if (Auth::check())
            <a class='tab' href="{{ route('history') }}">Geschiedenis</a>
            @endif
            <a class='tab' href="{{route('genres')}}">Genres</a>
            {{-- <a class='tab' href="{{route('customer-service')}}">Klantenservice</a> --}}
            @if (Auth::check())
                @if (Auth::user()->AboID == 5 || Auth::user()->AboID == 4)
                <a class='tab' href="{{ route('admin.manageSeries') }}">Manage</a>
                @endif
                @if (Auth::user()->AboID == 4)
                <a class='tab' href="{{ route('admin') }}">Admin</a>
                @endif
            @endif
            @if (!Auth::check())
            <a class='tab' href="{{ route('register') }}">Registreren</a>
            @endif
            @if (Auth::check())
                <a class='tab' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class='tab' href="{{ route('login') }}">Login</a>
            @endif
            @if (Auth::check())
            <a class='tab' href="{{ route('profiel', Auth::user()->KlantNr) }}">Profiel</a>
            @endif
            <a class='tab' href="{{ route('search') }}">Zoek</a>
        </article>
        @include('sidebar') 
    </header>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>