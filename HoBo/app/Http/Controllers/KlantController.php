<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlantController extends Controller
{

    public function register(Request $request)
    {
    
    // $request->validate([
    //     'abonnement' => 'required|integer',
    //     'voornaam' => 'required|string|max:255',
    //     'tussenvoegsel' => 'nullable|string|max:255',
    //     'achternaam' => 'required|string|max:255',
    //     'email' => 'required|email|unique:klant|max:255',
    //     'password' => 'required',
    //     'genre' => 'required|string|in:Male,Female,Other',
    // ]);

    $klant = new Klant();
    $klant->AboID = $request->input('abonnement');
    $klant->Voornaam = $request->input('voornaam');
    $klant->Tussenvoegsel = $request->input('tussenvoegsel');
    $klant->Achternaam = $request->input('achternaam');
    $klant->Email = $request->input('email');
    $klant->password = bcrypt($request->input('password'));
    $klant->Genre = $request->input('genre');
    $klant->save();
        // dd($klant);

    return redirect('/')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);
        
    
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }
    
        return back()->withInput()->withErrors(['username' => 'Invalid email or password.']);
    }

}
