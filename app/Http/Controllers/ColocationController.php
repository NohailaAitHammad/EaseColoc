<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationRequest;
use App\Models\Categorie;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\CategorieRequest;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Colocation::all();
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
        return view('colocations.show', compact('colocation'));
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
        $colocation->status = 'cancelled';
        $colocation->save();
        return redirect()->route('colocations.index')->with('success', 'Colocation a ete bien annuler');
    }
}
