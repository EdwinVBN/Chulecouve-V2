<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoBo</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c1c1c;
            margin: 0;
            padding: 20px;
            color: white;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        div {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
        }

        .series-image {
            max-width: 200px;  /* Adjust the value as needed */
            height: auto;
        }

        textarea {
            height: 100px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body id="home-body">
    @include('header')
    <main>
        <h1>Create Serie</h1>

        <form action="{{ route('admin.createSerie') }}" method="POST">
            @csrf

            <div>
                <label for="SerieTitel">Title:</label>
                <input type="text" name="SerieTitel" value="" required>
            </div>

            <div>
                <label for="IMDBLink">IMDB Link:</label>
                <input type="text" name="IMDBLink" value="">
            </div>

            <div>
                <label for="Image">Image:</label>
                <input type="text" name="Image" value="" placeholder="image-path, ex: img/img04.png">
            </div>

            <div>
                <label for="Description">Description:</label>
                <textarea name="Description"></textarea>
            </div>

            <div>
                <label for="Director">Director:</label>
                <input type="text" name="Director" value="">
            </div>

            <div>
                <label for="IMDBRating">IMDB Rating:</label>
                <input type="text" name="IMDBRating" value="">
            </div>

            <div>
                <label for="trailerVideo">Trailer Video:</label>
                <input type="text" name="trailerVideo" value="">
            </div>

            <button type="submit">Update</button>
        </form>
    </main>
</body>
</html>