<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationRequest;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Colocation::class, 'colocation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = auth()->user()->colocations;
        return view('colocations.index', compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usersDejaDansColocationActive = Membership::where('user_id', auth()->id())->whereNull('left_at')->exists();
        if($usersDejaDansColocationActive && auth()->user()->role_id !== 2){
            return back()->with('error', 'Utilisateur deja dans une colocation active');
        }
        return view('colocations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColocationRequest $request)
    {
        $validatedColocation = $request->validated();
        $validatedColocation['status'] = 'active';
        $colocation = Colocation::create($validatedColocation);
        $colocation->users()->attach(auth()->id(), ['role'=>'owner', 'joined_at' =>now()]);
        $owner = $colocation->users()
            ->wherePivot('role', 'owner')
            ->first();
        return redirect()->route('colocations.show', compact('colocation', 'owner'))->with('success', "Colocations creer avec succes");


    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        //dd($colocation->depenses);
        $memebres = $colocation->memberships()
            ->whereNull('left_at')
            ->with('user')
            ->get();
        return view('colocations.show', compact('colocation', 'memebres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColocationRequest $request, Colocation $colocation)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        //
    }

    public function cancel(Colocation $colocation)
    {
        if($colocation->owner()->first()->id !== auth()->id()){
            return  back()->with('erreur', 'vous pouverz pas annuler la colocation , acces non authorise');
        }
        $depensesNonPaye = $colocation->depenses()->whereHas('users', function ($query){
            $query->wherePivot('status', 'pending');
        })->exists();

        if($depensesNonPaye){
            return back()->with('error', "Impossible d’annuler la colocation : des dépenses ne sont pas encore payées.'");
        }
        $colocation->status = 'cancelled';
        $colocation->cancelled_at = now();
        $colocation->save();
        return redirect()->route('colocations.index')->with('success', 'Colocation a ete bien annuler');
    }

    public function quiter(Colocation $colocation)
    {
        $user = auth()->user();

        if ($colocation->status === 'cancelled') {
            return back()->with('error', "Colocation est deja annuler");
        }

        if ($colocation->owner()->first()->id === $user->id) {
            return back()->with('error', "Vous etes owner, transferer le role avant de quitter.");
        }

        if (!$colocation->users->contains($user->id)) {
            return back()->with('error', "Vous n'etes pas membre.");
        }

        $hasDebt = false;

        foreach ($colocation->depenses as $depense) {

            $pivot = $depense->users()
                ->where('user_id', $user->id)
                ->first();

            if ($pivot && $pivot->pivot->status === 'pending') {
                $hasDebt = true;
                break;
            }
        }

        // Reputation
        if ($hasDebt) {
            $user->decrement('reputation_score');
        } else {
            $user->increment('reputation_score');
        }

        // Suppression pivot depenses
        foreach ($colocation->depenses as $depense) {
            $depense->users()->detach($user->id);
        }

        // Suppression membre
        $colocation->users()->detach($user->id);

        $colocation->refresh();

        $colocation->recalculerDepenses();

        return redirect()
            ->route('colocations.index')
            ->with('success', 'Vous avez quitté la colocation');
    }

    public function retirer(Colocation $colocation, User $user)
    {
        $owner = auth()->user();

        // check owner
        if ($colocation->owner()->first()->id !== $owner->id) {
            return back()->with('error', 'Non autorisé');
        }

        if ($user->id === $owner->id) {
            return back()->with('error', 'Impossible de retirer le owner');
        }

        $hasDebt = false;

        foreach ($colocation->depenses as $depense) {

            $pivot = $depense->users()
                ->where('user_id', $user->id)
                ->first();

            if ($pivot && $pivot->pivot->status === 'pending') {

                $hasDebt = true;

                // ✅ transfert dette vers owner
                $depense->users()->updateExistingPivot(
                    $user->id,
                    ['user_id' => $owner->id]
                );
            }
        }

        // reputation
//        if ($hasDebt) {
//            $user->decrement('reputation_score');
//        } else {
//            $user->increment('reputation_score');
//        }

        // retirer membre
        $colocation->users()->detach($user->id);

        return back()->with('success', 'Membre retiré');
    }


}
