<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;

class PageController extends Controller
{
    public function home() {
        $series = Serie::whereNotNull('Image')->take(12)->get();

        return view('home', [
            'series' => $series,
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
