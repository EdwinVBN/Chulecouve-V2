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
            <h1>{{ $pick->SerieTitel }}</h1>
            <p>{{ $pick->Description }}</p>
            <a href="stream/{{ $pick->SerieID }}">
                <button id="watch">Kijk</button>
            </a>
        </section>
        <section class="carousel">
            <h1>Kijk verder</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($viewing as $serie)
                    <section class="carousel-section">
                        <a href="stream/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="{{ $serie->Image }}">
                        </a>
                        <p>{{ $serie->SerieTitel }}</p>
                    </section>
                @endforeach  
            </section>
        </section>
        
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

        <section class="carousel">
            <h1>Editors picks</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($picks as $serie)
                    <section class="carousel-section">
                        <a href="filminfo/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="{{ $serie->Image }}">
                        </a>
                        <p>{{ $serie->SerieTitel }}</p>
                    </section>
                @endforeach  
            </section>
        </section>
    </main>

    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <!-- <script src="{{ asset('js/modal.js') }}" defer></script> -->

</body>
</html>