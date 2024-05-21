<link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
<form action="{{ route('login.submit') }}" id="loginForm" method="post">
    @csrf
    <section class="login_vak">
        <label class="login_kop" for="username">username</label>
        <input placeholder="username" type="text" name="username" id="">
    </section>
    <section class="login_vak">
        <label class="login_kop" for="password">password</label>
        <input placeholder="password" type="password" name="password" id="">    
    </section>
    <input id="login_sumbit" type="submit" value="submit">
</form>
<?php if($errors->has('username')): ?>
    <script>
        alert("<?php echo $errors->first('username'); ?>");
    </script>
<?php endif; ?>
<script src="{{ asset('js/modal.js') }}" defer></script>