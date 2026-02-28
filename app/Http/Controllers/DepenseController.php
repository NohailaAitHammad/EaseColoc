<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepenseeRequest;
use App\Models\Categorie;
use App\Models\Colocation;
use App\Models\Depense;
use App\Models\depense_user;
use App\Models\User;


class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Colocation $colocation)
    {
        $depenses = $colocation->depenses;
        //dd($depenses);
        return view('colocations.depenses.index', compact('colocation','depenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Colocation $colocation)
    {
        $this->authorize('create', [Depense::class, $colocation]);
       $categories = $colocation->categories;
        return view('colocations.depenses.create', compact('colocation', 'categories' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepenseeRequest $request, Colocation $colocation)
    {
        if($colocation->status === 'cancelled'){
            return back()->with('error', 'Colocation est deja annuler');
        }

        $validatedDepense = $request->validated();

        $validatedDepense['colocation_id'] = $colocation->id;
        $validatedDepense['payeur_id'] = auth()->id();
        $validatedDepense['date'] = now();
        $validatedDepense['is_setled'] = 0 ;

        $depense  = $colocation->depenses()->create($validatedDepense);
        // depense non paye par les autres memebres
        //dd($depense->wasRecentlyCreated);
        $depense->calculDpenses();


        //dd($colocation->depenses()->users);
        return redirect()->route('colocations.show', $colocation )->with('success', 'Depense est bien cree');
    }

    /**
     * Display the specified resource.
     */
    public function payer( Colocation $colocation, Depense $depense, User $user)
    {
        //dd($user);
        $this->authorize('payee', [Depense::class, $depense]);
        if($depense->colocation->id !== $colocation->id){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
        }
        if($depense->is_setled){
            return back()->with('error', 'Depense est deja rembourser');
        }
        $depense->users()->updateExistingPivot($user->id, [
            'status' => 'payee'
        ]);
        $memebres = $colocation->memberships()
            ->whereNull('left_at')
            ->with('user')
            ->get();
        return view('colocations.show', compact('colocation', 'memebres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation, Depense $depense)
    {
        $this->authorize('update',$depense);

        if($depense->colocation->id !== $colocation->id){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
        }

        if($depense->users()->wherePivot('status','payee')->exists()){
            return back()->with('error', 'Depense en cours de paiement ');
        }
        if($depense->is_setled){
            return back()->with('error', 'Depense est deja rembourser');
        }

        return view('colocations.depenses.edit', compact('colocation','depense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepenseeRequest $request,Colocation $colocation,Depense $depense)
    {
        $validatedDepense = $request->validated();
        $depense->title = $validatedDepense['title'];
        $depense->montant = $validatedDepense['montant'];
        $depense->categorie_id = $validatedDepense['categorie_id'];

        $depens = $colocation->depenses()->save($depense);
        //$depense->save($validatedDepense);
        //dd($depense->wasRecentlyCreated);
        $depense->calculDpenses();

        return redirect()->route('colocations.show', compact('colocation'))->with('success', 'Depense est bien moifier');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation, Depense $depense)
    {
        $this->authorize('delete', $depense);
        if($depense->colocation->id !== $colocation->id){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
        }

        if($depense->users()->wherePivot('status','payee')->exists()){
            return back()->with('error', 'Depense en cours de paiement ');
        }
        if($depense->is_setled){
            return back()->with('error', 'Depense est deja rembourser');
        }
        $colocation->depenses()->where('id', $depense->id)->delete();
        return redirect()->route('colocations.show', compact('colocation'))->with('success', 'Depense est bien supprimer');
    }
}
