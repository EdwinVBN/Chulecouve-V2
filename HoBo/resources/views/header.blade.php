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
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @if (Auth::check())
                    <button type="submit">Logout</button>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endif
            </form>
            <!-- <a href="{{route('logout')}}">logout</a> -->
            <a href="{{ route('profiel') }}">Profiel</a>
            <a href="{{ route('search') }}">Zoek</a>
        </article>    
    </header>
    <!-- <script src="{{ asset('js/modal.js') }}" defer></script> -->
</body>
</html>