<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        // dd(Auth::id());
        // dd(Auth::user());
        // dd(Auth::check());

        return view('home');
    }

    public function contact()
    {
        return view('contact');
    }
}
