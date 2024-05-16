<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Genre;
use App\Models\Klant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Schema;

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

    public function home()
    {
        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();

        $recentlyWatched = session('recently_watched', collect());
        
        $seriesWithStreams = $recentlyWatched->merge($seriesWithStreams)->unique('SerieID');
        
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

    public function profile() {
        return view('profile');
    }

    public function settings() {
        return view('settings');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        // $active = Serie::where('Actief', 1)->inRandomOrder()->take(50)->get();
        $active = Serie::where('Actief', 1)->take(50)->get();

        if ($search == null) {
            return view('search', [
                'active' => $active,
            ]);
        }

        $series = [];

        $search_querys = explode(' ', $search);

        $query = Serie::query();

        $query->where(function ($subQuery) use ($search_querys) {
            foreach ($search_querys as $querys) {
                $subQuery->orWhere('SerieTitel', 'LIKE', "%$querys%");
                $subQuery->orWhereRaw('LEVENSHTEIN(SerieTitel, ?) <= 2', [$querys]);
            }
        });

        $series = $query
            ->orderByDesc('IMDBrating')
            ->whereNotNull('Image')
            ->get();

        return view('search', [
            'series' => $series,
            'search' => $search,
        ]);
    }
    public function profiel()
    {
        $user = Auth::user();

        if ($user) {
            return view('profiel', compact('user'));
        } else {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }
    }

    public function genre() {
        return view('genre');
    }

    public function stream($id)
    {
        $serie = Serie::find($id);
        Log::info('Found series with id: ' . $id, ['serie' => $serie]);
        $recentlyWatched = session('recently_watched', collect());
        if ($recentlyWatched->contains('SerieID', $serie->SerieID)) {
            $recentlyWatched = $recentlyWatched->filter(function ($item) use ($serie) {
                return $item->SerieID !== $serie->SerieID;
            });
        }
        Log::info('Current recently watched series: ', ['recently_watched' => $recentlyWatched]);

        $recentlyWatched = $recentlyWatched->prepend($serie)->unique('SerieID');
        Log::info('Updated recently watched series: ', ['recently_watched' => $recentlyWatched]);

        session(['recently_watched' => $recentlyWatched]);
        Log::info('Saved recently watched series to session', ['recently_watched' => session('recently_watched')]);

        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();
        $seriesWithStreams->prepend($serie);
        Log::info('Updated series with streams: ', ['seriesWithStreams' => $seriesWithStreams]);

        Log::info('Session stuff: ' . session('recently_watched', collect()));

        return view('stream', [
            'serie' => $serie
        ]);
    }

    public function history()
    {
        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();

        $recentlyWatched = session('recently_watched', collect());
        
        $seriesWithStreams = $recentlyWatched->merge($seriesWithStreams)->unique('SerieID');

        return view('history', [
            'recentlyWatched' => $seriesWithStreams
        ]);
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
