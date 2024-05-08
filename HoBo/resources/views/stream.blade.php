<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="stream-body">
    <video width="100%" height="auto" controls>
        <source src="" type="video/mp4">
    </video>
    <a href="/filminfo/{{ $serie->SerieID }}">
        <button>
            <img src="../img/left-chevron.png" alt="">
        </button>
    </a>
</body>
</html>