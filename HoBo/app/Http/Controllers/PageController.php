<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Genre;

class PageController extends Controller
{
    public function register(){
        $genres = Genre::all('genreNaam');

        // dd($genres);

        return view('register', [
            'genres' => $genres,
        ]);
    }

    public function login(){
        return view('login');
    }

    public function home() {
        $viewing = Serie::whereNotNull('Image')->take(9)->get();
        $active = Serie::where('Actief', 1)->inRandomOrder()->take(30)->get();
        $picks = Serie::whereNotNull('Image')->inRandomOrder()->take(30)->get();

        return view('home', [
            'viewing' => $viewing,
            'active' => $active,
            'picks' => $picks
        ]);
    }

    public function filminfo() {
        return view('filminfo');
    }

    public function history() {
        return view('history');
    }

    public function profile() {
        return view('profile');
    }

    public function search() {
        return view('search');
    }

    public function settings() {
        return view('settings');
    }

    public function stream() {
        return view('stream');
    }
}
