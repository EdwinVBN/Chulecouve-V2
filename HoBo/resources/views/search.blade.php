<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body id="home-body" style="background-image: none; background-color: rgb(26,26,26);">
    <main>
    <form method="GET" action="{{ route('search') }}" id="searchForm" style="width: 80%; margin-bottom: 20px;">
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
    <>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const microphoneBtn = document.getElementById('microphoneBtn');
    const searchInput = document.getElementById('searchInput');
    const recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    // Start listening when the page loads
    recognition.start();

    microphoneBtn.addEventListener('click', function() {
        if (recognition.isStarted) {
            recognition.stop();
        } else {
            recognition.start();
        }
    });

    recognition.onresult = function(event) {
        const transcript = event.results[event.results.length - 1][0].transcript;
        const searchCommand = 'search for';

        if (transcript.toLowerCase().startsWith(searchCommand)) {
            const query = transcript.slice(searchCommand.length).trim();
            searchInput.value = query;
            setTimeout(function() {
                document.getElementById('searchForm').submit();
            }, 500);
        }
    };

    recognition.onstart = function() {
        recognition.isStarted = true;
        microphoneBtn.classList.add('active');
    };

    recognition.onend = function() {
        recognition.isStarted = false;
        microphoneBtn.classList.remove('active');
        setTimeout(function() {
            recognition.start();
        }, 1000);
    };
});
</script>
</body>
</html>