<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\Abonnement;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 

class KlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Klant $klant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Klant $klant)
    {
        //
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        // $request->session()->invalidate();
    
        // $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'You have been logged out.');
    }

    /**
     * Update the specified resource in storage.
     */public function updateUserData(Request $request)
    {
        $data = $request->json()->all();
        $klantNr = $data['klantNr'];
        $klant = Klant::where('KlantNr', $klantNr)->first();

        if ($klant) {
            $field = $data['field'];
            $value = $data['value'];

            if ($field === 'Email') {
                $validator = Validator::make(['Email' => $value], Klant::$rules);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray(),
                    ], 422);
                }
            }

            if ($field === 'password') {
                $klant->password = bcrypt($value);
            } else {
                $klant->$field = $value;
            }

            if ($field === 'Naam') {
                $klant->Naam = $value;
            } else {
                $klant->$field = $value;
            }

            $klant->save();
            Log::info('Updated Klant:', ['updatedKlant' => $klant]);

            return response()->json(['success' => true]);
        } else {
            Log::error('Klant not found with KlantNr:', ['klantNr' => $klantNr]);
            return response()->json(['success' => false, 'error' => 'Klant not found'], 400);
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegistrationForm()
    {
        $abos = Abonnement::all();
        $genres = Genre::all();

        return view('register', [
            'abos' => $abos,
            'genres' => $genres,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $attempt = Auth::attempt($credentials);
        if ($attempt) {
            $user = Auth::getLastAttempted();
            Auth::login($user);
            session()->save();
            $redirect = redirect()->intended(route('home'));
            return $redirect;
        }

        $user = Klant::where('Email', $credentials['email'])->first();
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function register(Request $request)
    {
        if ($request->input('abonnement') == 4) {
            return redirect()->route('register')->with('error', 'You cannot register with this subscription.');
        }

        $email = $request->input('email');
        $klant = Klant::where('Email', $email)->first();
        if ($klant) {
            return redirect()->route('register')->with('error', 'Email already in use.');
        }

        $klant = new Klant();
        $klant->AboID = $request->input('abonnement');
        $klant->Voornaam = $request->input('voornaam');
        $klant->Tussenvoegsel = $request->input('tussenvoegsel');
        $klant->Achternaam = $request->input('achternaam');
        $klant->Email = $request->input('email');
        $klant->password = bcrypt($request->input('password'));
        $klant->Genre = $request->input('genre');
        $iban = str_replace(' ', '', $request->input('iban'));
        $klant->Iban = $iban;
        $klant->Address = $request->input('adress');
        $klant->save();

        $credentials = [
            'email' => $klant->Email,
            'password' => $request->input('password'),
        ];
        $attempt = Auth::attempt($credentials);
        if ($attempt) {
            $user = Auth::getLastAttempted();
            Auth::login($user);
            session()->save();
            return redirect()->route('home');
        }

        return redirect()->route('register')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Klant $klant)
    {
        //
    }
}
