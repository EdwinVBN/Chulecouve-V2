<link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
<form action="{{ route('home.submit') }}" method="post" id="registerForm">
    @csrf
    <section id="abonnentenVak">
        @foreach ($abos as $abo)
            <article id="abonnentVak">
                <h2>{{$abo->AboNaam}}</h2>
                <h3>{{$abo->MaxDevices}}</h3>
                <h4>{{$abo->StreamKwaliteit}}</h4>
                <input type="radio" name="abonnement" id="aboKnop" required value="{{$abo->AboID}}">
            </article>
        @endforeach

        <label for="iban">iban</label>
        <input required placeholder="iban" type="text" pattern="^NL\d{2} [A-Z]{4} \d{4} \d{4} \d{2}$" name="iban" id="">
        
        <input required id="registersubmit" type="submit" value="submit">
    </section>
    <section id="userVak">

        <section class="user_section">
            <label for="username">username</label>
            <input required placeholder="username" type="text" name="username" id="">   
        </section>
        
        <section class="user_section">
            <label for="email">Email</label>
            <input required placeholder="email" type="email" name="email" id="">      
        </section>
        
        <section class="user_section">
            <label for="password">password</label>
            <input required placeholder="password" type="password" name="password" id="">    
        </section>
    
    </section>
    <section id="persoonVak">

        <section class="persoon_section">
            <label for="voornaam">voornaam</label>
            <input required placeholder="voornaam" type="text" name="voornaam" id="">    
        </section>
        <section class="persoon_section">
            <label for="tussenvoegsel">tussenvoegsel</label>
            <input required placeholder="tussenvoegsel" type="text" name="tussenvoegsel" id="">
        </section>
        <section class="persoon_section">
            <label for="achternaam">achternaam</label>
            <input required placeholder="achternaam" type="text" name="achternaam" id="">
        </section>
        <section class="persoon_section">
            <label for="adress">adress</label>
            <input required placeholder="adress" type="text" name="adress" id="">    
        </section>
    </section>
    <section id="genrevak">
        <section class="genre_section">
            @foreach ($genres as $genre)
            <input required type="radio" name="genre" id="genre{{$loop->index}}" value="{{$genre->GenreNaam}}">
            <label for="genre{{$loop->index}}">{{$genre->GenreNaam}}</label><br>
            @endforeach
        </section>
    </section>           
    <section id="directionVak">
        <button class="dir_btn" id="previeus">previeus</button>    
        <button class="dir_btn" id="next">next</button>
    </section>    
</form>
<script src="{{ asset('js/modal.js') }}" defer></script>
<script src="{{ asset('js/register.js') }}"></script>