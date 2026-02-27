<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepenseeRequest;
use App\Models\Categorie;
use App\Models\Colocation;
use App\Models\Depense;


class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Colocation $colocation)
    {
        $depenses = $colocation->depenses();
        return view('colocations.depenses.index', compact('colocation','depenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Colocation $colocation)
    {
        $categories = Categorie::all();
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

        $colocation->depenses()->create($validatedDepense);
        return redirect()->route('colocations.show', $colocation)->with('success', 'Depense est bien cree');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation, Depense $depense)
    {
        if($depense->colocation !== $colocation){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
        }
        return view('colocations.depenses.show', compact('colocation','depense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation, Depense $depense)
    {
        if($depense->colocation !== $colocation){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
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
        $validatedDepense = $request->validaed();
        $depense->save($validatedDepense);
        return redirect()->route('colocations.depenses.index', compact('colocation'))->with('success', 'Depense est bien moifier');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation, Depense $depense)
    {
        if($depense->colocation !== $colocation){
            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
        }
        if($depense->is_setled){
            return back()->with('error', 'Depense est deja rembourser');
        }
        $depense->delete();
        return redirect()->route('colocations.depenses.index', compact('colocation'))->with('success', 'Depense est bien supprimer');
    }
}
