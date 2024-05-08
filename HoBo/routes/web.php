<?php

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
Route::get('/', [PageController::class, 'home']);

Route::get('/login', [PageController::class, 'login']);
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

Route::get('/register', [PageController::class, 'register']);
Route::post('/register', [UserController::class, 'register'])->name('register.submit');

Route::get('/filminfo/{id}', [PageController::class, 'filminfo']);
Route::get('/history', [PageController::class, 'history']);

Route::get('/profile', [PageController::class, 'profile']);

Route::get('/search', [PageController::class, 'search']);

Route::get('/settings', [PageController::class, 'settings']);
Route::get('/stream/{id}', [PageController::class, 'stream']);
