<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public  function home(){
        return view('home');
    }

    public function dashbord(){
        $colocations = auth()->user()->colocations;
        $latestDepenses = auth()->user()->colocations->where('status', 'active');

        return view('dashboard', compact('colocations', 'latestDepenses'));
    }
}
