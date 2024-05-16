<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body" style="background-image: none; background-color: rgb(26,26,26);">
    <main>
        <div style="position: absolute; top: 0; left: 0; width: 100%; padding: 0 90px;">
            <form method="GET" action="{{ route('search') }}" id="searchForm" style="width: 80%; margin-bottom: 20px;">
                <div style="border-bottom: 1px solid grey; display: flex; -webkit-box-align: center; align-items: center;">
                    <input style='padding: 48px 0; caret-color: white; width: 100%; font-family: "montserrat",sans-serif; font-size: 1rem; color: grey; background-color: transparent; border-bottom: 1px solid grey; border: none; outline: none;' type="text" name="search" id="searchform" placeholder="Waar ben je naar op zoek?">
                    <button type="submit" style="background:transparent; border:none; color:transparent;">Search</button>
                </dive>
            </form>
        </div>

        @if(isset($series) && isset($search))
        <section class="carousel">
            <h1>Gevonden items voor "{{ $search }}" </h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($series as $serie)
                    <section class="carousel-section">
                        <a href="filminfo/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="{{ $serie->Image }}">
                        </a>
                        <p>{{ $serie->SerieTitel }}</p>
                    </section>
                @endforeach  
            </section>
        </section>
        @else
        <section class="carousel">
            <h1>Trending</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($active as $serie)
                    <section class="carousel-section">
                        <a href="filminfo/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="{{ $serie->Image }}">
                        </a>
                        <p>{{ $serie->SerieTitel }}</p>
                    </section>
                @endforeach  
            </section>
        </section>
        @endif
    </main>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/modal.js') }}" defer></script>
</body>
</html>