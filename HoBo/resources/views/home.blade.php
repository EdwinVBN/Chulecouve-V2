<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <script src="{{ asset('js/carousel.js') }}" defer></script>
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
            <button id="next">next</button>
            <button id="prev">prev</button>
            <h1>Laatst gekeken</h1>
            <section class="carousel-images">
                @foreach ($series as $serie)
                     <img class="carousel-image" src="img/test.jpg">
                     <img class="carousel-image" src="img/test.jpg"> 
                @endforeach      
            </section>
        </section>       
    </main>
</body>
</html>