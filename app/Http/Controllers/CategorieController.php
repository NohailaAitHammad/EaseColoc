<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return view('categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request)
    {
        $validatedCategorie = $request->validated();
        Categorie::create($validatedCategorie);
        return redirect()->route('dashboard')->with("success", 'Catégorie bien cree');
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
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $validatedCategorie = $request->validated();
        $categorie->save($validatedCategorie);
        return redirect()->route('dashboard')->with('success', 'Catégorie Bien modifier');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return redirect()->route('dashboard')->with('success', 'Catégorie bien supprimer');
    }
}
