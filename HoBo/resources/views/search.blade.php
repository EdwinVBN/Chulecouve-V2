<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body>
<header>
        <article id="header-logo">
            <a href="/">
                <img src="img/HOBO_Beeldmerk.png">    
            </a>
        </article>
        <article id="header-right">
            <button id="login">login</button>
            <a href="">Profiel</a>
            <a href="{{ route('home') }}">Home</a>
        </article>    
    </header>
    <script src="{{ asset('js/modal.js') }}" defer></script>
</body>
</html>