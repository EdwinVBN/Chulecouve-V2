<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hobo</title>
</head>
<body>
    <style>
        :root {
            --primary-color: #92d051;
            --secondary-color: #5b9bd5;
            --dark-color: #444444;
            --light-color: #efefef;
            --title-font: "Neutra", sans-serif;
            --paragraph-font: "Montserrat", sans-serif;
        }

        #sidebar {
            width: 0;
            right: 0;
            top: 0;
            height: 100%;
            position: fixed;
            z-index: 9999999999999999999999999999999999999;
            background-color: white;
            display: flex;
            flex-direction: column;
            transition: width 0.5s ease;
        }

        #logo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgb(197, 197, 197);
            padding-bottom: 20px;
        }

        #img {
            width: 200px;
            padding-top: 20px;
        }

        #tabs {
            display: flex;
            flex-direction: column;
        }

        #tabs a {
            text-decoration: none;
            padding-top: 40px;
            padding-left: 20px;
            color: var(--secondary-color);
            font-family: var(--title-font);
            font-size: 18px;
        }

        #tabs a:hover {
            color: grey; 
        }
    </style>

    <section id="sidebar">
        <section id="logo">
            <img id='img' src='{{ asset('img/HOBO_Logo.png') }}'>
            <img id='close' onclick='closeBar()' src='{{ asset('img/close.png') }}'>
        </section>
        <section id='tabs'>
            <a href="{{ route('search') }}">Zoek</a>
            @if (Auth::check())
            <a href="{{ route('history') }}">Geschiedenis</a>
            @endif
            <a href="{{route('genres')}}">Genres</a>
            {{-- <a href="{{route('customer-service')}}">Klantenservice</a> --}}
            @if (Auth::check())
                @if (Auth::user()->AboID == 5 || Auth::user()->AboID == 4)
                <a href="{{ route('admin.manageSeries') }}">Manage</a>
                @endif
                @if (Auth::user()->AboID == 4)
                <a href="{{ route('admin') }}">Admin</a>
                @endif
            @endif
            @if (!Auth::check())
            <a href="{{ route('register') }}">Registreren</a>
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
            <a href="{{ route('profiel', Auth::user()->identificationString) }}">Profiel</a>
            @endif
        </section>
    </section>
</body>
</html>