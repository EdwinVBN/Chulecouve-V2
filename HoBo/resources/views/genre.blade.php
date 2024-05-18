<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    @include('header')

    <main>

    @foreach ($genres as $genre)
        <section class="carousel">
                <h1>{{$genre->GenreNaam}}</h1> 
                <button class="prev"><img src="img/left-chevron.png" alt=""></button>
                <button class="next"><img src="img/right-chevron.png" alt=""></button> 
                <section class="carousel-images">
                    @foreach ($genre->series as $serie)
                        <section class="carousel-section">
                            <a href="filminfo/{{ $serie->SerieID }}">
                                <img class="carousel-image" src="{{ $serie->Image }}">
                            </a>
                            <p>{{ $serie->SerieTitel }}</p>
                        </section>
                    @endforeach  
                </section>
        </section>
    @endforeach
    </main>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
</body>
</html>