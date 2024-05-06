<?php
// require __DIR__.'HoBo/vendor/autoload.php';

// $app = require_once __DIR__.'HoBo/bootstrap/app.php';

// $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// $kernel->bootstrap();

use App\Models\User;

if(isset($_POST['email'])){

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();

    $user->email = $email;
    $user->username = $username;
    $user->password = bcrypt($password);

    $user->save();

    return redirect()->route('login');

    // header("Location: /login");
    // exit();
}
?>
