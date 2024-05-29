<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../img/HOBO_beeldmerk.png">
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

        #login-body {
            background-color: var(--dark-color);
            background-image: url('../img/movie-wallpaper.jpg');
            background-repeat: none;
            background-size: cover;
            color: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: var(--paragraph-font);
        }

        #login-form {
            background-color: rgba(255, 255, 255, 1);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(131, 49, 49, 0.3);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
        }

        #login-form img{
            width: 200px;
            padding-bottom: 50px;
        }

        #login-form form{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center
        }

        #login-form h1 {
            font-family: var(--title-font);
            font-size: 32px;
            margin-bottom: 30px;
            color: var(--primary-color);
            animation: slideInDown 1s ease-in-out;
        }

        #login-form input {
            font-size: 16px;
            padding: 14px;
            margin-bottom: 20px;
            border: none;
            background-color: #fff;
            color: var(--dark-color);
            border-radius: 4px;
            transition: box-shadow 0.3s ease-in-out;
        }

        #login-form input:focus {
            outline: none;
            box-shadow: 0 0 5px var(--secondary-color);
        }

        #login-form button {
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            animation: slideInUp 1s ease-in-out;
        }

        #login-form button:hover {
            background-color: var(--secondary-color);
        }

        #login-form .form-group {
            margin-bottom: 25px;
        }

        #login-form .text-danger {
            color: #ff0a16;
            font-size: 14px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideInDown {
            0% {
                transform: translateY(-100%);
            }
            100% {
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            0% {
                transform: translateY(100%);
            }
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body id="login-body">
    <section id="login-form">
        <img src="../img/HOBO_logo.png">
        @if (Auth::check())
            <h1>Switch to another account</h1>
        @else
            <h1>Login</h1>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>