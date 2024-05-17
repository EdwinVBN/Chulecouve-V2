<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Genre;
use App\Models\Klant;
use App\Models\Abonnement;
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

    public function deleteUser($klantNr)
    {
        $user = Klant::findOrFail($klantNr);
        $user->delete();

        return redirect()->route('users')->with('success', 'User account deleted successfully.');
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

    public function users()
    {
        $users = Klant::all();
        $abbonementen = Abonnement::all();

        return view('users', [
            'users' => $users,
            'abbonementen' => $abbonementen,
        ]);
    }

    public function admin() {
        $series = Serie::all();
        $genres = Genre::all();
        $users = Klant::all();
    
        $seriesCount = $series->count();
        $genresCount = $genres->count();
        $usersCount = $users->count();

        $genreDistribution = Genre::withCount('series')->get();

        $topSeries = Serie::orderByDesc('IMDBrating')->take(10)->get();

        return view('admin', [
            'series' => $series,
            'genres' => $genres,
            'users' => $users,
            'seriesCount' => $seriesCount,
            'genresCount' => $genresCount,
            'usersCount' => $usersCount,
            'genreDistribution' => $genreDistribution,
            'topSeries' => $topSeries
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
        $active = Serie::where('Actief', 1)->take(50)->get();

        if ($search == null) {
            return view('search', [
                'active' => $active,
            ]);
        }

        $search_querys = explode(' ', $search);
        $search_querys = array_filter($search_querys, function ($query) {
            return strlen($query) >= 4;
        });

        if (empty($search_querys)) {
            return view('search', [
                'active' => $active,
                'search' => $search,
            ]);
        }

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

        $series = $series->map(function ($serie) use ($search_querys) {
            $relevance = 0;
            foreach ($search_querys as $querys) {
                if (stripos($serie->SerieTitel, $querys) !== false) {
                    $relevance += 2;
                } elseif (levenshtein($serie->SerieTitel, $querys) <= 2) {
                    $relevance++;
                }
            }
            $serie->relevance = $relevance;
            return $serie;
        });

        $series = $series->sortByDesc('relevance');

        return view('search', [
            'series' => $series,
            'search' => $search,
        ]);
    }

    public function editSerie($id)
    {
        $serie = Serie::findOrFail($id);
        return view('admin.edit-serie', ['serie' => $serie]);
    }

    public function updateSerie(Request $request, $id)
    {
        $serie = Serie::findOrFail($id);
        $serie->update([
            'SerieTitel' => $request->input('SerieTitel'),
            'IMDBLink' => $request->input('IMDBLink'),
            'Image' => $request->input('Image'),
            'Description' => $request->input('Description'),
            'Director' => $request->input('Director'),
            'IMDBRating' => $request->input('IMDBRating'),
            'trailerVideo' => $request->input('trailerVideo'),
        ]);
        return redirect()->route('admin.manageSeries')->with('success', 'Series updated successfully.');
    }

    public function deleteSerie($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();
        return redirect()->route('admin.manageSeries')->with('success', 'Series deleted successfully.');
    }

    public function manageSeries()
    {
        $series = Serie::all();
        return view('admin.series', ['series' => $series]);
    }
    public function profiel()
    {
        $user = Auth::user();

        $genres = Genre::all();

        if ($user) {
            return view('profiel', [
                'user' => $user,
                'genres' => $genres,
            ]);
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
