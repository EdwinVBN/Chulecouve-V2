<link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
<form action="{{ route('login.submit') }}" id="loginForm" method="post">
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
<script src="{{ asset('js/modal.js') }}" defer></script>