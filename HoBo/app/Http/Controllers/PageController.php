<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Genre;
use App\Models\Klant;
use App\Models\Abonnement;
use Illuminate\Support\Facades\DB;
use App\Models\Seizoen;
use App\Models\Serie_Genre;
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
        
        $recentlyWatched = collect($recentlyWatched)->map(function ($item) {
            return (object) $item;
        });

        $user = Auth::user();
    
        if($user){
            $recentlyWatchedb = $recentlyWatched->take(5);
            
            $recentlyWatchedGenres = $recentlyWatchedb->pluck('SerieID')->map(function($serieId) {
                return Serie_Genre::where('SerieID', $serieId)->pluck('GenreID');
            })->flatten()->unique();
            
            $forYouSerieIDs = Serie_Genre::whereIn('GenreID', $recentlyWatchedGenres)
                                          ->pluck('SerieID')
                                          ->unique();
                                          
            $forYouSeries = Serie::whereIn('SerieID', $forYouSerieIDs)
                                 ->where('Actief', 1)
                                 ->get();
            
            $forYouSeries = $forYouSeries->filter(function($serie) use ($recentlyWatched) {
                return !$recentlyWatched->contains('SerieID', $serie->SerieID);
            });
            $forYouSeries = $forYouSeries->sortBy(function($serie) use ($recentlyWatchedGenres) {
                $serieGenres = $serie->genres->pluck('GenreID');
                $minIndex = $recentlyWatchedGenres->search(function($genreId) use ($serieGenres) {
                    return $serieGenres->contains($genreId);
                });
                return $minIndex !== false ? $minIndex : PHP_INT_MAX;
            });
        } else {
            $forYouSeries = collect();
        }

        $seriesWithStreams = $recentlyWatched->merge($seriesWithStreams)->unique('SerieID');
        
        $active = Serie::where('Actief', 1)->inRandomOrder()->take(20)->get();
        $picks = Serie::whereNotNull('Image')->inRandomOrder()->take(20)->get();

        if (count($recentlyWatched) > 0) {
            $daredevil = Serie::find($recentlyWatched->first()->SerieID);
        } else {
            $daredevil = Serie::find(1);
        }
        
        $user = Auth::user();
        $userGenre = null;

        if($user){
            $userGenre = $user->Genre;
        };

        $userGenreID = Genre::where('GenreNaam', $userGenre)->pluck('GenreID')->first();

        $userSerieID = Serie_Genre::where('GenreID', $userGenreID)->pluck('SerieID')->all();
        $userSeries = Serie::whereIn('SerieID', $userSerieID)
                            ->wherein('Actief', [1])                    
                            ->get();

        // dd($userSeries);

        return view('home', [
            'viewing' => $seriesWithStreams,
            'active' => $active,
            'picks' => $picks,
            'forYouSeries' => $forYouSeries,
            'pick' => $daredevil,
            'userSeries' => $userSeries,
        ]);
    }

    public function deleteUser($klantNr)
    {
        $user = Klant::findOrFail($klantNr);
        $user->delete();

        return redirect()->route('users')->with('success', 'User account deleted successfully.');
    }

    public function filminfo($id, Request $request) {
        $serie = Serie::find($id);
        $test = $serie->genres;
        $seasonId = $request->input('season', 1); // Default to season 1 if not provided

        // Load only the episodes of the requested season
        $episodes = Serie::find($id)->episodes->filter(function($episode) use ($seasonId) {
            if (preg_match('/Aflevering S(\d+)E/', $episode->AflTitel, $matches)) {
                return $matches[1] == $seasonId;
            }
            return false;
        });

        // Extract season number from episode title
        foreach ($episodes as $episode) {
            if (preg_match('/Aflevering S(\d+)E/', $episode->AflTitel, $matches)) {
                $episode->seasonNumber = $matches[1];
            } else {
                $episode->seasonNumber = null; // or some default value
            }
        }

        $seasons = Seizoen::where('SerieID', $id)->get();
        $seasonArray = [];
        $seasonCounter = 1;

        foreach($seasons as $season) {
            $seasonObject = new \stdClass();
            $seasonObject->id = $seasonCounter;
            $seasonObject->name = "Seizoen " . $seasonCounter;
            array_push($seasonArray, $seasonObject);
            $seasonCounter++;
        }

        return view('filminfo', [
            'seasons' => $seasonArray,
            'serie' => $serie,
            'test' => $test,
            'episodes' => $episodes,
            'selectedSeason' => $seasonId
        ]);
    }

    public function genrePage()
    {
        $genres = Genre::with(['series' => function ($query) {
            $query->whereNotNull('Image');
        }])->get();

        $genres = $genres->filter(function ($genre) {
            return $genre->series->isNotEmpty();
        });

        return view('genre', compact('genres'));
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
        $serie = Serie::find($id);
        $data = [
            'SerieTitel' => $request->input('SerieTitel'),
            'IMDBLink' => $request->input('IMDBLink'),
            'Image' => $request->input('Image'),
            'Description' => $request->input('Description'),
            'Director' => $request->input('Director'),
            'IMDBrating' => $request->input('IMDBRating'),
            'trailerVideo' => $request->input('trailerVideo')
        ];

        Serie::withoutTimestamps(function () use ($id, $data) {
            Serie::where('SerieID', $id)->update($data);
        });

        dd($serie);

        return redirect()->route('admin.manageSeries')->with('success', 'Series updated successfully.');
    }

    public function deleteSerie($id)
    {
        $serie = Serie::findOrFail($id);
        $genre = Serie_Genre::where('SerieID', $id);
        $genre->delete();
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

    // PageController.php
    public function updateWatchtime(Request $request)
{
    try {
        $watchtime = $request->input('watchtime');
        Log::info('Received watchtime: ' . $watchtime);

        $user = Auth::user();
        Log::info('Authenticated user: ' . ($user ? $user->KlantNr : 'null'));

        if ($user) {
            DB::enableQueryLog();

            Log::info('Before updateOrInsert query');
            DB::table('klant')->updateOrInsert(
                ['KlantNr' => $user->KlantNr],
                ['totalWatched' => DB::raw('COALESCE(totalWatched, 0) + ' . $watchtime)]
            );
            Log::info('After updateOrInsert query');

            Log::info('Executed queries: ' . print_r(DB::getQueryLog(), true));
        } else {
            Log::warning('No authenticated user found');
        }

        Log::info('Update successful');
        $totalWatched = DB::table('klant')->where('KlantNr', Auth::user()->KlantNr)->value('totalWatched');
        Log::info('Total watched for user ' . ($user ? $user->KlantNr : 'null') . ': ' . $totalWatched);
        return response()->json(['success' => true]);
    } catch (\Throwable $e) {
        Log::error('Error updating watchtime: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json(['success' => false], 500);
    }
    }

    public function stream($id)
    {
        $serie = Serie::find($id);
        $recentlyWatched = session('recently_watched', collect());
        $recentlyWatched = collect($recentlyWatched)->map(function ($item) {
            return (object) $item;
        });
        if ($recentlyWatched->contains('SerieID', $serie->SerieID)) {
            $recentlyWatched = $recentlyWatched->filter(function ($item) use ($serie) {
                return $item->SerieID !== $serie->SerieID;
            });
        }

        $recentlyWatched = $recentlyWatched->prepend($serie)->unique('SerieID');

        session(['recently_watched' => $recentlyWatched]);

        $user = Auth::user();
        if ($user) {
            DB::table('sessions')->updateOrInsert(
                ['KlantNr' => $user->KlantNr],
                ['session_cookie' => session()->get('recently_watched')]
            );
        }

        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();
        $seriesWithStreams->prepend($serie);

        return view('stream', [
            'serie' => $serie
        ]);
    }

    public function history()
    {
        $seriesWithStreams = Serie::whereHas('seasons.episodes.streams')->get();

        $recentlyWatched = session('recently_watched', collect());
        $recentlyWatched = collect($recentlyWatched)->map(function ($item) {
            return (object) $item;
        });
        
        $seriesWithStreams = $recentlyWatched->merge($seriesWithStreams)->unique('SerieID');
        $user = Auth::user();
        $totalWatched = $user ? $user->totalWatched : 0;
        Log::info('Total watched for user ' . ($user ? $user->KlantNr : 'null') . ': ' . $totalWatched);

        return view('history', [
            'recentlyWatched' => $seriesWithStreams,
            'totalWatched' => $totalWatched,
        ]);
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }
}
