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
            <a href="">Zoek</a>
        </article>    
    </header>
    <main>
        <section id="home-info">
            <h1>{{ $serie->SerieTitel }}</h1>
            <p>Lorem ipsum dolor sit amet. Non exercitationem consequatur et repellendus minima qui dolorem laboriosam. Qui rerum maxime cum odit corporis ea minus asperiores ad impedit impedit. Vel dicta rerum et possimus dolorum est ducimus rerum. Nam consequuntur pariatur in totam tempore sit nulla sint qui enim atque in consectetur nemo et velit sint 33 aliquid voluptatem.</p>
            <a href="/stream/{{ $serie->SerieID }}">
                <button id="watch">Kijk</button>
            </a>
        </section>  
        <section id="info-movie">
            <h1>Genres: </h1>
            @foreach ($test as $genre)
                <p class="movieGenre">{{ $genre->GenreNaam }}</p>
            @endforeach
            <h1>Regisseur: </h1>
            <h1>Rating: </h1>
        </section>
    </main>
</body>
</html>