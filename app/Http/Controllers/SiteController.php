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

        return view('home');
    }

    public function dashboard(){
        if(auth()->user()->is_banned){
            return abort(403, 'Vous Etes banni');
        }

        $colocations = auth()->user()->colocations;
        $colocationsActives = $colocations->where('status', 'active')->count();
        $depensesTotal= 0;
        foreach ($colocations as $coloc){
            $depensesTotal += $coloc->depenses()->sum('montant');
        }

        return view('dashboard', compact('colocations', 'depensesTotal'));
    }

    public function index()
    {
        if(auth()->user()->role_id !== 2){
            return back()->with('error', "Acces non authorizer");
        }
        $stats = [
            'users' => User::where('role_id', 1)->count(),
            'colocations' => Colocation::count(),
            'depenses' => Depense::sum('montant')
        ];

        $users = User::select('id', 'firstName', 'lastName', 'email', 'is_banned')->where('role_id', 1)->get();

        return view('admin', compact('stats', 'users'));
    }

    public function toggleBan(User $user)
    {
        if(auth()->user()->is_banned){
            Auth::logout();
            return redirect()->route('login');
        }

        $user->is_banned = !$user->is_banned;

        if($user->is_banned){
            $user->banned_at = now();
        } else {
            $user->banned_at = null;
        }

        $user->save();

        if(auth()->id() === $user->id){
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte a été suspendu.');
        }

        return redirect()->route('admin.index')
            ->with('success', 'Statut utilisateur mis à jour');
    }
}
