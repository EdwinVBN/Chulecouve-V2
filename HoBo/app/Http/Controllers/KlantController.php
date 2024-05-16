<?php

namespace App\Http\Controllers;

use App\Models\Klant;
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
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
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

    public function login(Request $request)
    {
        $credentials = $request->only('Email', 'password');

        Log::info('Attempting login with credentials: ', $credentials);

        $attempt = Auth::attempt($credentials);

        // Log the result of the Auth::attempt() call
        Log::info('Auth::attempt() returned: ' . $attempt);

        if ($attempt) {
            // Authentication passed...
            Log::info('Authentication passed, redirecting to home');
        
            // Manually log the user in
            $user = Auth::getLastAttempted();
            Log::info('Last attempted user: ' . $user);
            Auth::login($user);
            session()->save();
        
            // Log the session data before redirect
            Log::info('Session data before redirect: ', $request->session()->all());
        
            $redirect = redirect()->intended(route('home'));
        
            // Log the session data after redirect
            Log::info('Session data after redirect: ', $request->session()->all());
        
            return $redirect;
        }

        $user = Klant::where('Email', $credentials['Email'])->first();
        Log::info('User found in database: ' . $user);

        Log::warning('Authentication failed for email: ' . $credentials['Email']);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Klant $klant)
    {
        //
    }
}
