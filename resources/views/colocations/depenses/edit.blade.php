@extends('layouts.app')

@section('content')
    <main class="flex flex-col flex-1 w-full items-center justify-center p-6 ">
        <div class="w-full max-w-2xl px-8 py-10 bg-white rounded-2xl shadow-lg dark:bg-gray-800">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Modifier  Depense
                </h2>
                @if ($errors->any())
                    <div class="bg-red-200 p-2">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <form action="{{ route('colocations.depenses.update',[$colocation, $depense]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="title" :value="__('Titre de la depense')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$depense->title" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="montant" :value="__('Montant de la depense')" />
                            <x-text-input id="montant" class="block mt-1 w-full" type="number" name="montant" :value="$depense->montant" required autofocus autocomplete="montant" />
                            <x-input-error :messages="$errors->get('montant')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="categorie_id" :value="__('Categorie')" />

                            <select id="categorie_id" name="categorie_id">
                                @foreach($colocation->categories as $category)
                                    <option value="{{$category->id}}"> {{ $category->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="submit" class="px-10 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Enregistrer
                            </button>
                            <a href="{{ route('colocations.index')}}" class="px-10 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
