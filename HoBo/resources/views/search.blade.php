<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoeken</title>
    <link rel="icon" type="image/x-icon" href="img/HOBO_beeldmerk.png">
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body id="home-body" style="background-image: none; background-color: rgb(26,26,26);">
    <main>
    <form method="GET" action="{{ route('search') }}" id="searchForm" style="width: 100%; margin-bottom: 20px;">
        <div style="border-bottom: 1px solid grey; display: flex; -webkit-box-align: center; align-items: center;">
            <input style='padding: 48px 0; caret-color: white; width: 100%; font-family: "montserrat",sans-serif; font-size: 1rem; color: grey; background-color: transparent; border-bottom: 1px solid grey; border: none; outline: none;' type="text" name="search" id="searchInput" placeholder="Waar ben je naar op zoek?">
            <button type="button" id="microphoneBtn" class="microphone-btn" style="background: transparent; border:none; color: white;">
                <i class="fa fa-microphone"></i>
            </button>
            <button type="submit" style="background:transparent; border:none; color:transparent;">Search</button>
        </div>
    </form>

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
    <script src="{{ asset('js/speech.js') }}" defer></script>
</body>
</html>

