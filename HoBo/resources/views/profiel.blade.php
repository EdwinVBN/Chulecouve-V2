<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="icon" type="image/x-icon" href="img/HOBO_beeldmerk.png">
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    <header>
        <article id="header-logo">
            <a href="/">
                <img src="{{asset('img/HOBO_Beeldmerk.png')}}">    
            </a>
        </article>
        <article id="header-right">
            <img id='hamburger' src='../img/hamburger.png' onclick="openBar()">
            @if (Auth::check())
            <a class='tab' href="{{ route('history') }}">Geschiedenis</a>
            @endif
            <a class='tab' href="{{route('genres')}}">Genres</a>
            <a class='tab' href="{{route('customer-service')}}">Klantenservice</a>
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
    </header>
        <section class="main-top" style="display: flex; justify-content: center">
            <section class="user-info-view" style="display: flex;">
                <section>
                    <h1>Account Gegevens</h1>
                    <img src="../img/YaL3s.jpg">
                </section>
                <section style="color: black;">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <p class="editable-container">Voornaam: <span class="editable" id="Voornaam">{{$user->Voornaam}}</span></p>
                    <p class="editable-container">Tussenvoegsel: <span class="editable" id="Tussenvoegsel">{{$user->Tussenvoegsel}}</span></p>
                    <p class="editable-container">Achternaam: <span class="editable" id="Achternaam">{{$user->Achternaam}}</span></p>
                    <p class="editable-container">Wachtwoord: <span class="editable" id="password">{{str_repeat("*" , 8)}}</span></p>
                    <p class="editable-container">Email address: <span class="editable" id="Email">{{$user->Email}}</span></p>
                    <p>Naam: {{$user->Voornaam . ' ' . $user->Tussenvoegsel . ' ' . $user->Achternaam}}</p>
                    <p>Adress: {{$user->Address}}</p>
                    <!-- <p>Adress: CENSORED</p> -->
                    <p>Iban: {{$user->Iban}}</p>
                    <h1 style="color: black;">Voorkeur:
                        <span class="editable" id="Genre">{{ $user->Genre }}</span>
                        <select id="genreSelect">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->GenreID }}" {{ $user->Genre == $genre->GenreNaam ? 'selected' : '' }}>
                                    {{ $genre->GenreNaam }}
                                </option>
                            @endforeach
                        </select>
                    </h1>
                </section>
            </section>
        </section>

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
    
            #close {
                width: 20px;
                height: 20px;
                padding-right: 20px;
                margin-top: 20px;
                cursor: pointer;
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
                <img id='img' src='../img/HOBO_Logo.png'>
                <img id='close' onclick='closeBar()' src='../img/close.png'>
            </section>
            <section id='tabs'>
                <a href="{{ route('search') }}">Zoek</a>
                @if (Auth::check())
                <a href="{{ route('history') }}">Geschiedenis</a>
                @endif
                <a href="{{route('genres')}}">Genres</a>
                <a href="{{route('customer-service')}}">Klantenservice</a>
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
                <a href="{{ route('profiel', Auth::user()->KlantNr) }}">Profiel</a>
                @endif
            </section>
        </section>
        <script src="{{ asset('js/modal.js') }}" defer></script>
        <script src="{{ asset('js/editable.js') }}" defer></script>
        <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
