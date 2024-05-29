<?php

use App\Http\Controllers\KlantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerServiceController;
use Illuminate\Support\Facades\Auth;


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
    Route::post('/logout', [KlantController::class, 'logout'])->name('logout')->middleware('auth');
    Route::get('/history', [PageController::class, 'history'])->name('history')->middleware('auth');
    Route::get('/filminfo/{id}', [PageController::class, 'filminfo'])->name('filminfo');
    Route::get('/profile', [PageController::class, 'profile'])->middleware('auth');
    Route::get('/search', [PageController::class, 'search'])->name('search');
    Route::get('/genres', [PageController::class, 'genrePage'])->name('genres');
    Route::get('/profiel/{KlantNr}', [PageController::class, 'profiel'])->name('profiel')->middleware('auth');
    Route::get('/genre', [PageController::class, 'genre'])->name('genre')->middleware('auth');
    Route::get('/settings', [PageController::class, 'settings'])->middleware('auth');
    Route::get('/stream/{id}', [PageController::class, 'stream'])->name('stream')->middleware('auth');
    Route::get('/admin', [PageController::class, 'admin'])->name('admin')->middleware('auth');
    Route::post('/update-user-data', [KlantController::class, 'updateUserData'])->name('update-user-data')->middleware('auth');
    Route::delete('/admin/users/{id}', [PageController::class, 'deleteUser'])->name('admin.deleteUser')->middleware('auth');
    Route::get('/admin/users', [PageController::class, 'users'])->name('users');
    Route::get('/admin/series', [PageController::class, 'manageSeries'])->name('admin.manageSeries')->middleware('auth', 'contentmanager');
    Route::get('/admin/series/{id}/edit', [PageController::class, 'editSerie'])->name('admin.editSerie')->middleware('auth', 'contentmanager');
    Route::delete('/admin/series/{id}', [PageController::class, 'deleteSerie'])->name('admin.deleteSerie')->middleware('auth', 'contentmanager');
    Route::get('/admin/series/{id}/edit', [PageController::class, 'editSerie'])->name('admin.editSerie')->middleware('auth', 'contentmanager');
    Route::put('/admin/series/{id}', [PageController::class, 'updateSerie'])->name('admin.updateSerie')->middleware('auth', 'contentmanager');
    Route::delete('/admin/series/{id}', [PageController::class, 'deleteSerie'])->name('admin.deleteSerie')->middleware('auth', 'contentmanager');

    Route::post('/customer-service/request', [CustomerServiceController::class, 'handleRequest']);
    Route::get('/customer-service', function () {
        return view('customer-service');
    })->name('customer-service');

    Route::get('login', [KlantController::class, 'showLoginForm'])->name('login');
    Route::post('login', [KlantController::class, 'login']);
    Route::get('/register', [KlantController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [KlantController::class, 'register'])->name('register.submit');
});
