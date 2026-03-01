<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public  function home(){
        return view('home');
    }

    public function dashboard(){
        $colocations = auth()->user()->colocations;
        $latestDepenses = auth()->user()->colocations;
        $colocationsActives = $latestDepenses->where('status', 'active')->count();
        $depensesTotal= 0;
        foreach ($latestDepenses as $coloc){
            $depensesTotal += $coloc->depenses()->sum('montant');
        }

        return view('dashboard', compact('colocations', 'latestDepenses', 'depensesTotal'));
    }

//    public function index() {
//        return view('dashboard');
//    }


}
