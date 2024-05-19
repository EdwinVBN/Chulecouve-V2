<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Neutra&family=Montserrat&display=swap" rel="stylesheet">
        <style>
        :root {
            --primary-color: #92d051;
            --secondary-color: #5b9bd5;
            --dark-color: #444444;
            --light-color: #efefef;
            --title-font: "Neutra", sans-serif;
            --paragraph-font: "Montserrat", sans-serif;
        }
        #register-body {
        background: var(--dark-color) url('../img/movie-wallpaper.jpg') no-repeat center center fixed;
        background-size: cover;
        color: var(--light-color);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        font-family: var(--paragraph-font);
    }

    #register-form {
        background-color: rgba(255, 255, 255, 1);
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
        max-width: 600px;
        width: 100%;
    }

    #register-form h1 {
        font-family: var(--title-font);
        font-size: 32px;
        margin-bottom: 30px;
        color: var(--primary-color);
        animation: slideInDown 1s ease-in-out;
    }

    #register-form label {
        display: block;
        text-align: left;
        margin-bottom: 8px;
        font-size: 16px;
        color: black;
    }

    #register-form input[type="text"],
    #register-form input[type="email"],
    #register-form input[type="password"],
    #register-form select {
        width: 100%;
        font-size: 16px;
        padding-bottom: 14px;
        padding-top: 14px;
        border: 1px solid grey;
        background-color: #fff;
        color: var(--dark-color);
        border-radius: 4px;
        transition: box-shadow 0.3s ease-in-out;
    }

    #register-form input[type="text"]:focus,
    #register-form input[type="email"]:focus,
    #register-form input[type="password"]:focus,
    #register-form select:focus {
        outline: none;
        box-shadow: 0 0 5px var(--secondary-color);
    }

    #register-form input[type="radio"] {
        margin-right: 8px;
    }

    #register-form #abonnentenVak {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 20px;
    }

    #register-form #abonnentVak {
        background-color: var(--light-color);
        padding: 20px;
        border-radius: 4px;
        text-align: center;
        width: 30%;
        margin: 0 !important;
    }

    #register-form button {
        padding: 12px 24px;
        background-color: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        animation: slideInUp 1s ease-in-out;
    }

    #register-form button:hover {
        background-color: var(--secondary-color);
    }

    #register-form .form-group {
        margin-bottom: 25px;
    }
</style>
</head>
<body id="register-body">
    <section id="register-form">
        <h1>Register</h1>
        <form action="{{ route('register.submit') }}" method="post" id="registerForm">
            @csrf
            <article id="abonnentenVak" style="color: #5b9bd5">
                @foreach ($abos as $abo)
                @if ($abo->AboID != 4)
                    <article id="abonnentVak" style="margin-right: 5%;">
                        <h2>{{$abo->AboNaam}}</h2>
                        <h3>{{$abo->MaxDevices}}</h3>
                        <h4>{{$abo->StreamKwaliteit}}</h4>
                        <input type="radio" name="abonnement" id="aboKnop" value="{{$abo->AboID}}">
                    </article>
                @endif
                @endforeach
            </article>
            <div class="form-group">
                <label for="voornaam">First Name</label>
                <input placeholder="First Name" type="text" name="voornaam" id="voornaam" required>
            </div>
            <div class="form-group">
                <label for="tussenvoegsel">Middle Name</label>
                <input placeholder="Middle Name" type="text" name="tussenvoegsel" id="tussenvoegsel">
            </div>
            <div class="form-group">
                <label for="achternaam">Last Name</label>
                <input placeholder="Last Name" type="text" name="achternaam" id="achternaam" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input placeholder="Email" type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input placeholder="Password" type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="iban">IBAN</label>
                <input placeholder="NL54ABNA0123981319" type="text" pattern="NL[a-zA-Z0-9]{2}\s?([a-zA-Z]{4}\s?){1}([0-9]{4}\s?){2}([0-9]{2})\s?" name="iban" id="iban" required>
            </div>
            <div class="form-group">
                <label for="adress">Address</label>
                <input placeholder="Straat, Stad, Postcode" type="text" name="adress" id="adress" required>
            </div>
            <div class="form-group">
                <label for="genre">Favorite Genre</label>
                <select name="genre" id="genre" required>
                    <option value="" disabled selected>Select a genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{$genre->GenreNaam}}">{{$genre->GenreNaam}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Register</button>
        </form>
    </section>
</body>
</html>