<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Afficher le panel admin avec stats et utilisateurs
     */
    public function index()
    {
        // Statistiques globales
        $stats = [
            'users' => User::count(),
            'colocations' => Colocation::count(),
            'expenses' => Depense::sum('amount')
        ];

        // Liste des utilisateurs
        $users = User::select('id', 'name', 'email', 'banned')->get();

        // Retourner la vue Blade avec variables
        return view('admin.panel', compact('stats', 'users'));
    }

    /**
     * Bannir / débannir un utilisateur
     */
    public function toggleBan(User $user)
    {
        $user->banned = !$user->banned;
        $user->save();

        return redirect()->route('admin.index')->with('success', 'Statut utilisateur mis à jour');
    }
}
