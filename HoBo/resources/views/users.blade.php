<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoBo</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color:#333;
        }

        .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
        color: #333;
        margin-bottom: 20px;
    }
    
    .alert {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .table th,
    .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #333;
    }
    
    .table th {
        background-color: #f2f2f2;
    }

    
    .btn {
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        color: #fff;
        cursor: pointer;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
</head>
<body id="home-body">
    @include('header')
    <div class="container">
        <h1>Users</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Membership</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->KlantNr }}</td>
                        <td>{{ $user->Voornaam . ' ' . $user->Tussenvoegsel . ' ' . $user->Achternaam}}</td>
                        <td>{{ $user->Email }}</td>
                        <td>{{$abbonementen[$user->AboID - 1]->AboNaam}}</td>
                        <td>
                            <form action="{{ route('admin.deleteUser', $user->KlantNr) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('profiel', $user->identificationString)}}" method="GET">
                                <button type="submit" class="btn btn-danger">Bewerk</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>