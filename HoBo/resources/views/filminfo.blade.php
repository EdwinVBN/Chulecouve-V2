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
            <button id="login">Login</button>
            <a href="">Profiel</a>
            <a href="">Zoek</a>
        </article>    
    </header>
    <main>
        <section id="popup">
            <section id="form-body">
                <article id="form-head">
                    header
                </article>
                <article id="form-main">
                    body
                </article>
                <article id="form-foot">
                    <button id="closebutton">Close</button>
                </article>    
            </section>
        </section>
        <section id="home-info">
            <h1>{{ $serie->SerieTitel }}</h1>
            <p>{{ $serie->Description }}</p>
            <a href="/stream/{{ $serie->SerieID }}">
                <button id="watch">Kijk</button>
            </a>
        </section>  
        <section id="info-movie">
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
            <h1>IMDB Link: </h1>
            <a href={{$serie->IMDBLink}}>
                <p class="movieGenre">Click here!</p>
            </a>
        </section>
        <section id="carousel-info" class="carousel">
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
    <script src="{{ asset('js/modal.js') }}" defer></script>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
</body>
</html>