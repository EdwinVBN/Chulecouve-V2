<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="info-body">
    <header>
        <article id="header-logo">
            <a href="/">
                <img src="../img/HOBO_Beeldmerk.png">    
            </a>
        </article>
        <article id="header-right">
            <a href="">Profiel</a>
            <a href="{{ route('search') }}">Zoek</a>
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
            <div style="position: absolute; right: 0; bottom: 20%;">
                <img src="../{{ $serie->Image }}" alt="{{$serie->SerieTitel}}" style="max-width: 70%; border: 1px solid transparent; border-radius: 25px;">
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

    <script src="{{ asset('js/carousel.js') }}" defer></script>

</body>
</html>