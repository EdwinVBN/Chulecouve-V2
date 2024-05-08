<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    <header>
        <article id="header-logo">
            <img src="img/HOBO_Beeldmerk.png">
        </article>
        <article id="header-right">
            <a href="">home</a>
        </article>    
    </header>
    <main>
        <form action="{{ route('register.submit') }}" method="post">
            @csrf
            <label for="voornaam">voornaam</label><br>
            <input placeholder="voornaam" type="text" name="voornaam" id="">
            <br><br>
            <label for="tussenvoegsel">tussenvoegsel</label><br>
            <input placeholder="tussenvoegsel" type="text" name="tussenvoegsel" id="">
            <br><br>
            <label for="achternaam">achternaam</label><br>
            <input placeholder="achternaam" type="text" name="achternaam" id="">
            <br><br>
            <label for="email">Email</label><br>
            <input placeholder="email" type="email" name="email" id="">
            <br><br>
            <label for="password">password</label><br>
            <input placeholder="password" type="password" name="password" id="">
            <br><br>           
            <input type="submit" value="submit">
            @foreach ($genres as $genre)
            <label for="genre">{{$genre->GenreNaam}}</label><br>

            @endforeach
        </form>
    </main>
</body>
</html>