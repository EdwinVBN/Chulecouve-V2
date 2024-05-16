<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    <header style="display: flex;">
        <article style="flex: 1;" id="home">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('history') }}" class="btn btn-primary">Geschiedenis</a>
        </article>
            <article style="flex: 2; justify-content:center;" id="header-logo">
                <a href="/">
                    <img src="../img/HOBO_Beeldmerk.png">    
                </a>
            </article>
            <article style="flex: 1;" id="header-right">
                <a href="{{ route('search') }}">Zoek</a>
                <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
            </article>    
        </header>
        <section class="main-top" style="display: flex; justify-content: center">
            <section class="user-info-view" style="display: flex;">
                <section>
                    <h1>Account Gegevens</h1>
                    <img src="../img/YaL3s.jpg">
                </section>
                <section style="color: white;">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <p class="editable-container">Naam: <span class="editable" id="Naam">{{$user->Voornaam . ' ' . $user->Tussenvoegsel . ' ' . $user->Achternaam}}</span></p>
                    <p class="editable-container">Wachtwoord: <span class="editable" id="password">{{str_repeat("*" , 8)}}</span></p>
                    <p class="editable-container">Email address: <span class="editable" id="Email">{{$user->Email}}</span></p>
                </section>
            </section>
            <section class="user-info-view">
                <h1 style="color: white;">Voorkeur: {{$user->Genre}}</h1>
            </section>
        </section>
        <section class="main-bottom">
            <section style="color: white;" class="betalings-gegevens-view">
                <p>Naam: {{$user->Voornaam . ' ' . $user->Tussenvoegsel . ' ' . $user->Achternaam}}</p>
                <p>Adress: {{$user->Address}}</p>
                <p>Iban: {{$user->Iban}}</p>
            </section>
        </section>
        <script src="{{ asset('js/modal.js') }}" defer></script>
        <script src="{{ asset('js/editable.js') }}" defer></script>
</body>
</html>
