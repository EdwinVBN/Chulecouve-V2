<link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
<form action="{{ route('home.submit') }}" method="post" id="registerForm">
    @csrf
    <article id="abonnentenVak">
        @foreach ($abos as $abo)
            <article id="abonnentVak">
                <h2>{{$abo->AboNaam}}</h2>
                <h3>{{$abo->MaxDevices}}</h3>
                <h4>{{$abo->StreamKwaliteit}}</h4>
                <input type="radio" name="abonnement" id="aboKnop" value="{{$abo->AboID}}">
            </article>
        @endforeach
    </article>
    <label for="username">username</label>
    <input placeholder="username" type="text" name="username" id="">

    <label for="voornaam">voornaam</label>
    <input placeholder="voornaam" type="text" name="voornaam" id="">

    <label for="tussenvoegsel">tussenvoegsel</label>
    <input placeholder="tussenvoegsel" type="text" name="tussenvoegsel" id="">

    <label for="achternaam">achternaam</label>
    <input placeholder="achternaam" type="text" name="achternaam" id="">

    <label for="email">Email</label>
    <input placeholder="email" type="email" name="email" id="">

    <label for="password">password</label>
    <input placeholder="password" type="password" name="password" id="">

    <label for="iban">iban</label>
    <input placeholder="iban" type="text" pattern="^NL\d{2} [A-Z]{4} \d{4} \d{4} \d{2}$" name="iban" id="">

    <label for="adress">adress</label>
    <input placeholder="adress" type="text" name="adress" id="">


    <article id="genrevak">
        @foreach ($genres as $genre)
        <input type="radio" name="genre" id="genre{{$loop->index}}" value="{{$genre->GenreNaam}}">
        <label for="genre{{$loop->index}}">{{$genre->GenreNaam}}</label><br>
        @endforeach    
    </article>           
    <input type="submit" value="submit">
</form>
<script src="{{ asset('js/modal.js') }}" defer></script>