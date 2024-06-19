<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOBO</title>
    <link rel="icon" type="image/x-icon" href="img/HOBO_beeldmerk.png">
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    @include('header')
    <main>
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
        @if (Auth::check() && count($viewing) > 0)
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
        @endif
        
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

        @if (Auth::check() && $forYouSeries->isNotEmpty())
        <section class="carousel">
            <h1>Gebaseerd op jouw kijkgeschiedenis</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($forYouSeries as $serie)
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
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <!-- <script src="{{ asset('js/modal.js') }}" defer></script> -->
</body>
</html>