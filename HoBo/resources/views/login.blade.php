<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    @if (Auth::check())
        <!-- The user is logged in... -->
        <p>Hello, {{ Auth::user()->name }}</p>
    @else
        <!-- The user is not logged in... -->
        <p>You are not logged in</p>
    @endif
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="Email">Email:</label>
            <input type="email" id="email" name="Email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>