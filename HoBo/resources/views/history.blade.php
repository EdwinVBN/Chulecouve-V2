<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <style>
    </style>
</head>
<body id="home-body">
<header style="display: flex;">
        <article style="flex: 1;" id="home">
            <a href="{{ route('home') }}">Home</a>
        </article>
            <article style="flex: 2; justify-content:center;" id="header-logo">
                <a href="/">
                    <img src="img/HOBO_Beeldmerk.png">    
                </a>
            </article>
            <article style="flex: 1;" id="header-right">
                <a href="{{ route('profiel', 10005) }}">Profiel</a>
                <a href="{{ route('search') }}">Zoek</a>
                <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
            </article>    
        </header>
    <main>
    <section class="carousel">
        <h1>History</h1>
        <button class="prev"><img src="img/left-chevron.png" alt=""></button>
        <button class="next"><img src="img/right-chevron.png" alt=""></button>
        <section class="carousel-images">
            @foreach ($recentlyWatched as $serie)
                <section class="carousel-section">
                    <a href="stream/{{ $serie->SerieID }}">
                        <img class="carousel-image" src="{{ $serie->Image }}">
                    </a>
                    <p>{{ $serie->SerieTitel }}</p>
                </section>
            @endforeach
        </section>
    </section>
    </main>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
</body>
</html>