<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geschiedenis</title>
    <link rel="icon" type="image/x-icon" href="img/HOBO_beeldmerk.png">
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <!DOCTYPE html>
<html lang="en">
<body id="home-body">
    @include('header') 
    <main>
    <section class="carousel">
        @if (count($recentlyWatched) > 0)
        <h1>History</h1>
        <button class="prev"><img src="img/left-chevron.png" alt=""></button>
        <button class="next"><img src="img/right-chevron.png" alt=""></button>
        <section class="carousel-images">
            @foreach ($recentlyWatched as $serie)
                <section class="carousel-section">
                    <a href="stream/{{ $serie->SerieID }}">
                        <img class="carousel-image" src="{{ $serie->Image }}">
                    </a>
                    <p>{{ $serie->SerieTitel }}</p>
                </section>
            @endforeach
        </section>
        @else
        <h1 style="text-align: center; margin-top: 10%; margin-bottom: 20%;">No history found</h1>
        @endif
    </section>
    <section class="total-watched">
        <h2>Total Watch Time</h2>
        <p>
            {{ floor($totalWatched / 86400) }} days, 
            {{ floor(($totalWatched % 86400) / 3600) }} hours, 
            {{ floor(($totalWatched % 3600) / 60) }} minutes, 
            {{ $totalWatched % 60 }} seconds
        </p>
    </section>
    </main>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
</body>
</html>