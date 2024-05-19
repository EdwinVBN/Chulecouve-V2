<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$serie->SerieTitel}}</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="info-body">
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
            <a class='tab' href="{{route('customer-service')}}">Customer Service</a>
            @if (Auth::check())
                @if (Auth::user()->AboID == 5 || Auth::user()->AboID == 4)
                <a class='tab' href="{{ route('admin.manageSeries') }}">Manage</a>
                @endif
                @if (Auth::user()->AboID == 4)
                <a class='tab' href="{{ route('admin') }}">Admin</a>
                @endif
            @endif
            @if (!Auth::check())
            <a class='tab' href="{{ route('register') }}">Register</a>
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
    <main>
        <section id="home-info">
            <div>
                <h1>{{ $serie->SerieTitel }}</h1>
                <p>{{ $serie->Description }}</p>
                <a href="/stream/{{ $serie->SerieID }}">
                    <button id="watch">Kijk</button>
                </a>
            </div>
        </section>
        <section id="info-movie" style="margin-top: 20px;">
            <h1>Genres: </h1>
            @if(count($test) > 0)
                @foreach ($test as $genre)
                    <p class="movieGenre">{{ $genre->GenreNaam }}</p>
                @endforeach
            @else
                <p class="movieGenre">No genres found.</p>
            @endif
            <h1>Regisseur: </h1>
                <p class="movieGenre">{{ $serie->Director }}</p>
            <h1>Rating: </h1>
                <p class="movieGenre">{{ $serie->IMDBrating }}</p>
        </section>
        <section class="carousel">
            <h1>Afleveringen</h1> 
            <button class="prev"><img src="../img/left-chevron.png" alt=""></button>
            <button class="next"><img src="../img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($episodes as $episode)
                    <section class="carousel-section">
                        <a href="../stream/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="../{{ $serie->Image }}">
                        </a>
                        <p>{{ $episode->AflTitel }}</p>
                    </section>
                @endforeach  
            </section>
        </section>
    </main>




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
        </section>
    </section>

    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>