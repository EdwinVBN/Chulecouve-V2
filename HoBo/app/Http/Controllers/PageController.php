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

    public function customerService() {
        return view('customer-service');
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

        $recentlyWatched = $recentlyWatched->filter(function ($item) {
            return Serie::find($item->SerieID) !== null;
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

    public function expireUser($identificationString)
    {
        $user = Klant::where('identificationString', $identificationString)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User does not exist.']);
        }

        if (Auth::user()->AboID != 4)
        {
            return redirect()->back()->withErrors(['error' => 'Unauthorized']);
        }

        if ((now()->greaterThan($user->expiration_time))) {
            return redirect()->back()->withErrors(['error' => 'This subscribtion is already expired!']);
        }

        $user->update([
            'expiration_time' => now()->subHour()
        ]);

        $user->save();

        return redirect()->route('profiel', $identificationString)->with('success', 'You expired ' . $user->Voornaam . "'s active subscribtion!");

    }

    public function renew($identificationString) {
        $user = Klant::where('identificationString', $identificationString)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User does not exist.']);
        }

        if (!(now()->greaterThan($user->expiration_time))) {
            return redirect()->back()->withErrors(['error' => 'You can only renew when your subscribtion is expired']);
        }

        $user->update([
            'expiration_time' => now()->addDays(30)
        ]);

        $user->save();

        return redirect()->route('profiel', $identificationString)->with('success', 'Thank you for renewing your HoBo subscribtion!');


    }
    public function isContentManager()
    {
        $user = Auth::user();
        return $user->AboID >= 4;
    }

    public function isAdmin() 
    {
        $user = Auth::user();
        return $user->AboID == 4;
    }

    public function seriesCreate(Request $request)
    {
        if (!$this->isContentManager()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to create series']);
        }
        $method = $request->method();
        if ($method == 'POST') {
            $latestSeriesId = Serie::max('SerieID');
            $createdSerieNumber = $latestSeriesId+=1;
            $data = [
                'SerieID' => $createdSerieNumber,
                'SerieTitel' => $request->input('SerieTitel'),
                'IMDBLink' => $request->input('IMDBLink'),
                'Image' => $request->input('Image'),
                'Actief' => 1,
                'Description' => $request->input('Description'),
                'Director' => $request->input('Director'),
                'IMDBrating' => $request->input('IMDBRating'),
                'trailerVideo' => $request->input('trailerVideo')
            ];

            Serie::withoutTimestamps(function () use ($data) {
                Serie::create($data);
            });

            return redirect()->route('admin.manageSeries')->with('success', 'Created series succesfully');

        }
        elseif ($method == 'GET') {
            return view('admin/create-serie');
        }
    }

    public function deleteUser($klantNr)
    {
        if (!$this->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to delete users']);
        }
        $user = Klant::findOrFail($klantNr);
        $user->delete();

        return redirect()->route('users')->with('success', 'User account deleted successfully.');
    }

    public function filminfo($id, Request $request) {
        $serie = Serie::find($id);
        $test = $serie->genres;
        $seasonId = $request->input('season', 1);

        $episodes = Serie::find($id)->episodes->filter(function($episode) use ($seasonId) {
            if (preg_match('/Aflevering S(\d+)E/', $episode->AflTitel, $matches)) {
                return $matches[1] == $seasonId;
            }
            return false;
        });

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
        if (!$this->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to view users']);
        }
        $users = Klant::all();
        $abbonementen = Abonnement::all();

        return view('users', [
            'users' => $users,
            'abbonementen' => $abbonementen,
        ]);
    }

    public function admin() {
        if (!$this->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to view the admin page']);
        }
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

        return view('search', [
            'series' => $series,
            'search' => $search,
        ]);
    }

    public function editSerie($id)
    {
        if (!$this->isContentManager()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to edit series']);
        }
        $serie = Serie::findOrFail($id);
        return view('admin.edit-serie', ['serie' => $serie]);
    }

    public function updateSerie(Request $request, $id)
    {
        if (!$this->isContentManager()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to update series']);
        }
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

        return redirect()->route('admin.manageSeries')->with('success', 'Series updated successfully.');
    }

    public function deleteSerie($id)
    {
        if (!$this->isContentManager()) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to delete series']);
        }
        $serie = Serie::findOrFail($id);
        $genre = Serie_Genre::where('SerieID', $id);
        $recentlyWatched = session('recently_watched', collect());
        $recentlyWatched = collect($recentlyWatched)->map(function ($item) {
            return (object) $item;
        });
        $recentlyWatched = $recentlyWatched->filter(function ($item) use ($serie) {
            return $item->SerieID !== $serie->SerieID;
        });
        session(['recently_watched' => $recentlyWatched]);
        $genre->delete();
        $serie->delete();
        return redirect()->route('admin.manageSeries')->with('success', 'Series deleted successfully.');
    }

    public function manageSeries()
    {
        $series = Serie::all();
        return view('admin.series', ['series' => $series]);
    }
    public function profiel($identificationString)
    {
        // $user = Auth::user();
        $user = Klant::where('identificationString', $identificationString)->first();
        if (!$user) {
            return redirect()->back();
        }
        $genres = Genre::all();
        $abonnement = Abonnement::find($user->AboID);

        $lidmaatschappen = Abonnement::all();

        if ($user) {
            return view('profiel', [
                'user' => $user,
                'abo' => $abonnement,
                'genres' => $genres,
                'lidmaatschappen' => $lidmaatschappen,
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }
    }

    public function CreateSerie()
    {
        return redirect()->back();
    }

    public function genre() {
        return view('genre');
    }

    // PageController.php
    public function updateWatchtime(Request $request)
    {
    try {
        $watchtime = $request->input('watchtime');

        $user = Auth::user();

        if ($user) {
            DB::enableQueryLog();

            DB::table('klant')->updateOrInsert(
                ['KlantNr' => $user->KlantNr],
                ['totalWatched' => DB::raw('COALESCE(totalWatched, 0) + ' . $watchtime)]
            );

        } else {
            Log::warning('No authenticated user found');
        }

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
        if (!$serie) {
            return redirect()->route('home')->withErrors(['error' => 'Serie with ID ' . $id . ' not found. | redirected to home']);
        }
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
