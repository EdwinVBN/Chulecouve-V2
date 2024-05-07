<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        
        $user = new User();
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        
        return redirect('/login');
    }

    public function showLoginForm()
    { 
        return view('login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);
        
    
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/home');
        }
    
        return back()->withInput()->withErrors(['username' => 'Invalid email or password.']);
    }

}
