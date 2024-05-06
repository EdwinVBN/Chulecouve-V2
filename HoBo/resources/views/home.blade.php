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
        <section id="home-info">
            <h1>Title</h1>
            <p>Lorem ipsum dolor sit amet. Non exercitationem consequatur et repellendus minima qui dolorem laboriosam. Qui rerum maxime cum odit corporis ea minus asperiores ad impedit impedit. Vel dicta rerum et possimus dolorum est ducimus rerum. Nam consequuntur pariatur in totam tempore sit nulla sint qui enim atque in consectetur nemo et velit sint 33 aliquid voluptatem.</p>
            <button id="watch">Kijk</button>
        </section>
        <section class="carousel">
            <h1>Laatst gekeken</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($viewing as $serie)
                    <img class="carousel-image" src="{{ $serie->Image }}">
                @endforeach  
            </section>
        </section>
        
        <section class="carousel">
            <h1>Trending</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($active as $serie)
                    <img class="carousel-image" src="{{ $serie->Image }}">
                @endforeach  
            </section>
        </section>

        <section class="carousel">
            <h1>Editors picks</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($picks as $serie)
                    <img class="carousel-image" src="{{ $serie->Image }}">
                @endforeach  
            </section>
        </section>
    </main>

    <script src="{{ asset('js/carousel.js') }}" defer></script>
</body>
</html>