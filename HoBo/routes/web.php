<?php

use App\Http\Controllers\KlantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', [PageController::class, 'home'])->name('home');

    Route::post('/logout', [KlantController::class, 'logout'])->name('logout');
        
    Route::get('/history', [PageController::class, 'history'])->name('history');

    Route::get('/filminfo/{id}', [PageController::class, 'filminfo']);

    Route::get('/profile', [PageController::class, 'profile']);

    Route::get('/search', [PageController::class, 'search'])->name('search');

    Route::get('/profiel/{klantNr}', [PageController::class, 'profiel'])->name('profiel');

    Route::get('/genre', [PageController::class, 'genre'])->name('genre');

    Route::get('/settings', [PageController::class, 'settings']);
    Route::get('/stream/{id}', [PageController::class, 'stream'])->name('stream');

    Route::post('/update-user-data', [KlantController::class, 'updateUserData'])->name('update-user-data');

    // Move these routes inside the web middleware group
    Route::get('login', [KlantController::class, 'showLoginForm'])->name('login');
    Route::post('login', [KlantController::class, 'login']);
    Route::get('/register', [PageController::class, 'register']);
    Route::post('/register', [UserController::class, 'register'])->name('register.submit');
});