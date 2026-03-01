<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public  function home(){
        if(auth()->user()){
            return view('dashboard');
        }
        return view('home');
    }

    public function dashboard(){
        if(auth()->user()->is_banned){
            return view('home');
        }
        $colocations = auth()->user()->colocations;
        $latestDepenses = auth()->user()->colocations;
        $colocationsActives = $latestDepenses->where('status', 'active')->count();
        $depensesTotal= 0;
        foreach ($latestDepenses as $coloc){
            $depensesTotal += $coloc->depenses()->sum('montant');
        }

        return view('dashboard', compact('colocations', 'latestDepenses', 'depensesTotal'));
    }

    public function index()
    {
        if(auth()->user()->is_banned){
            return view('home');
        }
        // Statistiques globales
        $stats = [
            'users' => User::where('role_id', 1)->count(),
            'colocations' => Colocation::count(),
            'depenses' => Depense::sum('montant')
        ];

        // Liste des utilisateurs
        $users = User::select('id', 'firstName', 'lastName', 'email', 'is_banned')->where('role_id', 1)->get();

        // Retourner la vue Blade avec variables
        return view('admin', compact('stats', 'users'));
    }

    public function toggleBan(User $user)
    {
        if(auth()->user()->is_banned){
            return view('home');
        }
        $user->is_banned = !$user->is_banned;
        $user->banned_at = now();
        //dd($user->is_banned);
        $user->save();
        Auth::logout();
        $user->refresh();

        return redirect()->route('admin.index')->with('success', 'Statut utilisateur mis à jour');
    }


//    public function index() {
//        return view('dashboard');
//    }


}
