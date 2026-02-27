@extends('layouts.app')

@section('content')
    <main class="flex flex-col flex-1 w-full items-center justify-center p-6 ">
        <div class="w-full max-w-2xl px-8 py-10 bg-white rounded-2xl shadow-lg dark:bg-gray-800">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Modifier  Categorie
                </h2>
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <form action="{{ route('categories.update', $categorie)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="nom" :value="__('Nom de Categorie')" />
                            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="$categorie->nom" required autofocus autocomplete="nom" />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-10 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
