<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
    $klant->Username = $request->input('username');
    $klant->Voornaam = $request->input('voornaam');
    $klant->Tussenvoegsel = $request->input('tussenvoegsel');
    $klant->Achternaam = $request->input('achternaam');
    $klant->Email = $request->input('email');
    $klant->password = bcrypt($request->input('password'));
    $klant->Genre = $request->input('genre');
    $iban = str_replace(' ', '', $request->input('iban'));
    $klant->Iban = $iban;
    $klant->adress = $request->input('adress');
    $klant->save();
        // dd($klant);

    return redirect('/')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        // $request->validate([
        //     'username' => 'required|string',
        //     'password' => 'required',
        // ]);
        
    
        $credentials = $request->only('username', 'password');
        Log::info('Credentials: ' . $credentials['username'] . $credentials['password']);
        $attempt = Auth::attempt($credentials);
        Log::info('Attempt: ' . $attempt);
        if ($attempt) {
            $user = Auth::getLastAttempted();
            Log::info('Detected user: ' . $user);
            Auth::login($user);
            session()->save();



            return redirect('/');

        }
    
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();        
        return redirect('/')->with('success', 'You have been logged out.'); 
    }

}
