<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        return view('home');
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
