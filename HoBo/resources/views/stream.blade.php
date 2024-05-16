<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="stream-body">
    @if ($serie->trailerVideo == null)
        <iframe width="100%" height="auto" src="https://www.youtube.com/embed/2VzzsLyWWLo?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <a href="/filminfo/{{ $serie->SerieID }}">
            <button>
                <img src="../img/left-chevron.png" alt="">
            </button>
        </a>
    @else
    <iframe width="100%" height="auto" src="{{$serie->trailerVideo}}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <a href="/filminfo/{{ $serie->SerieID }}">
        <button>
            <img src="../img/left-chevron.png" alt="">
        </button>
    </a>
    @endif
</body>
</html>