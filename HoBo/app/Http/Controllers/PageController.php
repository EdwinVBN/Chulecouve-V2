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
        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();
        $active = Serie::where('Actief', 1)->inRandomOrder()->take(20)->get();
        $picks = Serie::whereNotNull('Image')->inRandomOrder()->take(20)->get();
        $daredevil = Serie::find(215);

        return view('home', [
            'viewing' => $seriesWithStreams,
            'active' => $active,
            'picks' => $picks,
            'pick' => $daredevil
        ]);
    }

    public function filminfo($id) {
        $serie = Serie::find($id);
        $test = $serie->genres;
        $episodes = Serie::find($id)->episodes;

        return view('filminfo', [
            'serie' => $serie,
            'test' => $test,
            'episodes' => $episodes
        ]);
    }

    public function history() {
        return view('history');
    }

    public function profile() {
        return view('profile');
    }

    public function settings() {
        return view('settings');
    }

    public function search(Request $request) {
        $search = $request->input('search');
        $active = Serie::where('Actief', 1)->inRandomOrder()->take(50)->get();

        if ($search == null) {
            return view('search', [
                'active' => $active,
            ]);
        }

        $series = Serie::where('SerieTitel', 'LIKE', "%$search%")
            ->whereNotNull('Image')
            ->get();

        return view('search', [
            'series' => $series,
            'search' => $search,
        ]);
    }

    public function stream($id) {
        $serie = Serie::find($id);

        return view('stream', [
            'serie' => $serie
        ]);
    }
}
