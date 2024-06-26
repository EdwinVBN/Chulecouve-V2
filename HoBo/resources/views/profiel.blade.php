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
            <a class='tab' href="{{ route('profiel', Auth::user()->identificationString) }}">Profiel</a>
            @endif
            <a class='tab' href="{{ route('search') }}">Zoek</a>
        </article>
    </header>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: black; list-style-type: none;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="main-top" style="display: flex; justify-content: center">
            <section class="user-info-view">
                <section class="profile-section centered-profile">
                    <h1>Account Gegevens</h1>
                    <img src="../img/YaL3s.jpg">
                    <h1 style="color: black;">Lidmaatschap:
                    {{$abo->AboNaam}}
                    <p>Maximum Aantal Devices: {{$abo->MaxDevices}}</p>
                    <p>Stream Kwaliteit: {{$abo->StreamKwaliteit}}p</p>
                    @if (Auth::user()->AboID == 4 && Auth::user()->identificationString != $user->identificationString)
                    <a style="color: black; text-decoration: none; font-size: 80%" href="{{route('expireUser', $user->identificationString)}}">Expire User</a>
                        <select class="editable" id="AboID">
                        @foreach ($lidmaatschappen as $lidmaatschap)
                                <option value="{{ $lidmaatschap->AboID }}" {{ $user->AboID == $lidmaatschap->AboID ? 'selected' : '' }}>
                                    {{ $lidmaatschap->AboNaam }}
                                </option>
                        @endforeach
                        </select>
                    @endif
                        @if (now()->greaterThan($user->expiration_time))
                            <a style="color: black; text-decoration: none;" href="{{ route('renew', $user->identificationString) }}">Renew</a>
                        @else
                        @endif
                    </h1>
                </section>
                @if (Auth::user()->KlantNr == $user->KlantNr || Auth::user()->AboID == 4)
                <section class="profile-section" style="color: black;">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <p class="editable-container"><span class="editable-label">Voornaam:</span> <span class="editable" id="Voornaam">{{$user->Voornaam}}</span></p>
                    <p class="editable-container"><span class="editable-label">Tussenvoegsel:</span><span class="editable" id="Tussenvoegsel"> {{$user->Tussenvoegsel ? $user->Tussenvoegsel : 'Geen tussen-voegsel'}}</span></p>
                    <p class="editable-container"><span class="editable-label">Achternaam:</span> <span class="editable" id="Achternaam">{{$user->Achternaam}}</span></p>
                    <p class="editable-container"><span class="editable-label">Wachtwoord:</span> <span class="editable" id="password">{{str_repeat("*" , 8)}}</span></p>
                    <p class="editable-container"><span class="editable-label">Email address:</span> <span class="editable" id="Email">{{$user->Email}}</span></p>
                </section>
                <section class="profile-section">
                    <p>Naam: {{$user->Voornaam . ' ' . $user->Tussenvoegsel . ' ' . $user->Achternaam}}</p>
                    <!-- <p>Adress: {{$user->Address}}</p> -->
                    <p class="editable-container"><span class="editable-label">Adres:</span> <span class="editable" id="Address">{{$user->Address}}</span></p>
                    <p class="editable-container"><span class="editable-label">IBAN:</span> <span class="editable" id="Iban">{{$user->Iban}}</span></p>
                    <h1 style="color: black;">Voorkeur:
                        <select class="editable" id="Genre">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->GenreID }}" {{ $user->Genre == $genre->GenreNaam ? 'selected' : '' }}>
                                    {{ $genre->GenreNaam }}
                                </option>
                            @endforeach
                        </select>
                    </h1>
                </section>
                <section class="profile-section" style="text-align: center">
                    <p>Abonnement Type: {{$abo->AboNaam;}} | 
                        @if (now()->greaterThan($user->expiration_time))
                            Expired
                        @else
                            Expires: {{$user->expiration_time}}
                        @endif
                        </p>
                        <a href="{{ route('deletehistory', $user->identificationString) }}" style="color: black; text-decoration: none;">Verwijder Geschiedenis</a>
                </section>
                @else
                <section class="profile-section">
                    <h1 style="color: black">GEEN TOEGANG!</h1>
                </section>
                @endif
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
        <script src="{{ asset('js/modal.js') }}" defer></script>
        <script src="{{ asset('js/editable.js') }}" defer></script>
        <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
