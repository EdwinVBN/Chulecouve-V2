<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoBo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: none;
            margin: 0;
            padding: 20px;
        }
         .container {
        max-width: 960px;
        margin: 0 auto;
    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .col-md-4 {
        flex-basis: 30%;
    }

    .card {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
    }

    .card-title {
        color: #333;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card-text {
        color: #666;
        font-size: 24px;
        font-weight: bold;
    }
</style>
</head>
<body id="home-body" style="background-image: none; background-color: rgb(26,26,26);">
    @if (Auth::check() && Auth::user()->AboID == 4)
    <main>
    <div class="container">
    @include('header')
        <h1 style="color: #5b9bd5;">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Series</h5>
                        <p class="card-text">{{ $seriesCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Genres</h5>
                        <p class="card-text">{{ $genresCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('users') }}"style='text-decoration: none; color: #333'>Total Users</a></h5>
                        <p class="card-text">{{ $usersCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="carousel">
            <h1 style="color: #5b9bd5;">Huidige Top Films</h1> 
            <button class="prev"><img src="img/left-chevron.png" alt=""></button>
            <button class="next"><img src="img/right-chevron.png" alt=""></button> 
            <section class="carousel-images">
                @foreach ($topSeries as $serie)
                    <section class="carousel-section">
                        <a href="stream/{{ $serie->SerieID }}">
                            <img class="carousel-image" src="{{ $serie->Image }}">
                        </a>
                        <p>{{ $serie->SerieTitel }}</p>
                    </section>
                @endforeach  
            </section>
    </section>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    </main>
    @else
    <h1>Unauthorized</h1>
    @endif
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>