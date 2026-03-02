<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CategorieController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Categorie::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Colocation $colocation)
    {
        $this->authorize('viewAny',[Categorie::class, $colocation]);
        $categories = $colocation->categories;
        return view('colocations.categories.index', compact('colocation','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Colocation $colocation)
    {
        $this->authorize('create', [Categorie::class, $colocation]);
        return view('colocations.categories.create', compact('colocation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request, Colocation $colocation)
    {

        $validatedCategorie = $request->validated();
        $validatedCategorie['user_id'] = auth()->id();
        $categorie = $colocation->categories()->create($validatedCategorie);
        return redirect()->route('colocations.categories.index', $colocation)->with("success", 'Catégorie bien cree');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation, Categorie $category)
    {
        return view('colocations.categories.edit', compact('colocation','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request,Colocation $colocation, Categorie $category)
    {
        $this->authorize('update',$category);
        $validatedCategorie = $request->validated();
        $category->nom = $validatedCategorie['nom'];
        $colocation->categories()->save($category);
        return redirect()->route('colocations.categories.index', $colocation)->with('success', 'Catégorie Bien modifier');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation, Categorie $category)
    {
        if($category->colocation->id !== $colocation->id){
            return back()->with('error',"Categorie n'appartient pas a cette colocation");
        }
        $colocation->categories()->where('id', $category->id)->delete();
        return redirect()->route('colocations.categories.index', $colocation)->with('success', 'Catégorie bien supprimer');
    }
}
