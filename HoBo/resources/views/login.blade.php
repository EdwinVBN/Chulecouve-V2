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
        <form action="{{ route('login.submit') }}" method="post">
            @csrf
            <label for="username">username</label><br>
            <input placeholder="username" type="text" name="username" id="">
            <br><br>
            <label for="password">password</label><br>
            <input placeholder="password" type="password" name="password" id="">
            <br><br>
            <input type="submit" value="submit">
        </form>
        <?php if($errors->has('username')): ?>
            <script>
                alert("<?php echo $errors->first('username'); ?>");
            </script>
        <?php endif; ?>
    </main>
</body>
</html>