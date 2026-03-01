<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepenseeRequest;
use App\Models\Categorie;
use App\Models\Colocation;
use App\Models\Depense;
use App\Models\depense_user;
use App\Models\User;
use http\Client\Request;


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
    public function show(Colocation $colocation, Depense $depense)
    {
        return view('colocations.depenses.show', compact('colocation', 'depense'));
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
//    public function payer( Colocation $colocation, Depense $depense, User $user)
//    {
//        //dd($user);
//
//        $this->authorize('payee', [Depense::class, $depense]);
//        if($depense->colocation->id !== $colocation->id){
//            return back()->with('error', "Cette depense n'appartient pas a cette colocation");
//        }
//
//        $pivot = $depense->users()->where('user_id', auth()->id())->first()?->pivot;
//        if (!$pivot) {
//            return back()->with('error', "Vous n'êtes pas concerné par cette dépense.");
//        }
//        if($pivot->status === 'payee'){
//            return back()->with('error', 'Vous avez déjà payé cette dépense.');
//        }
//
//        $depense->users()->updateExistingPivot($user->id, [
//            'status' => 'payee',
//            'montant_paye' => $pivot->montant_du,
//        ]);
//        $encoreNonPaye = $depense->users()->wherePivotColumn('montant_paye', '<', 'montant_du')->exists();
//        if(!$encoreNonPaye){
//            $depense->update([
//                'is_setled' => true,
//            ]);
//        }
//        $memebres = $colocation->memberships()
//            ->whereNull('left_at')
//            ->with('user')
//            ->get();
//        return view('colocations.show', compact('colocation', 'memebres'))->with('success', 'Paiement effectué avec succès.');
//    }

    public function payer(Colocation $colocation, Depense $depense, User $user)
    {
        $this->authorize('payee', [Depense::class, $depense]);

        if($depense->colocation->id !== $colocation->id){
            return back()->with('error', "Cette dépense n'appartient pas à cette colocation");
        }

        $pivot = $depense->users()
            ->where('user_id', auth()->id())
            ->first()?->pivot;

        if (!$pivot) {
            return back()->with('error', "Vous n'êtes pas concerné par cette dépense.");
        }

        if($pivot->status === 'payee'){
            return back()->with('error', 'Vous avez déjà payé cette dépense.');
        }

        // Mise à jour pivot
        $depense->users()->updateExistingPivot(auth()->id(), [
            'status' => 'payee',
            'montant_paye' => $pivot->montant_du,
        ]);

        // Vérifier si tout le monde a payé
        $encoreNonPaye = $depense->users()
            ->whereRaw('depense_user.montant_paye < depense_user.montant_du')
            ->exists();

        if(!$encoreNonPaye){
            $depense->update([
                'is_setled' => true,
            ]);
        }

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Paiement effectué avec succès.');
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

//    public function stats(Colocation $colocation, Request $request)
//    {
//        // Filtrage par mois si demandé
//        $query = $colocation->depenses();
//
//        if($request->filled('month') && $request->filled('year')){
//            $query->whereYear('date', $request->year)
//                ->whereMonth('date', $request->month);
//        }
//
//        $depenses = $query->get();
//
//        // Stats par catégorie
//        $statsCategorie = $depenses->groupBy('categorie_id')->map(function($items){
//            return $items->sum('montant');
//        });
//
//        // Stats mensuelles (total par mois)
//        $statsMensuelles = $colocation->depenses()
//            ->get()
//            ->groupBy(function($item){
//                return $item->date->format('Y-m'); // ex: 2026-03
//            })
//            ->map(function($items){
//                return $items->sum('montant');
//            });
//
//        return view('colocations.depenses.stats', compact('colocation', 'depenses', 'statsCategorie', 'statsMensuelles'));
//    }

    public function stats(Colocation $colocation, Request $request)
    {
        $query = $colocation->depenses();

        // Filtrage par mois (input type="month")
        if($request->filled('month')){
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        }

        $depenses = $query->get();

        // Stats par catégorie avec nom
        $statsCategorie = $depenses->groupBy('categorie_id')->mapWithKeys(function($items, $catId) use ($colocation) {
            $catName = $colocation->categories->find($catId)?->name ?? 'Autre';
            return [$catName => $items->sum('montant')];
        });

        // Stats mensuelles (filtrées ou toutes selon filtre)
        $statsMensuelles = $depenses->groupBy(function($item){
            return $item->date->format('Y-m');
        })->map(fn($items) => $items->sum('montant'));

        return view('colocations.depenses.index', compact('colocation', 'depenses', 'statsCategorie', 'statsMensuelles'));
    }

}
