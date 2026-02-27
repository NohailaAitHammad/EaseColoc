@extends('layouts.app')

@section('content')
    <main class="flex flex-col flex-1 w-full items-center justify-center p-6 ">
        <div class="w-full max-w-2xl px-8 py-10 bg-white rounded-2xl shadow-lg dark:bg-gray-800">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Nouvelle  Colocation
            </h2>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form action="{{ route('colocations.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-input-label for="nom" :value="__('Nom de Colocation')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="max_membres" :value="__('Nombre maximum de membres')" />
                        <x-text-input id="max_membres" class="block mt-1 w-full" type="number" name="max_membres" :value="old('max_membres')" required autofocus autocomplete="max_membres" />
                        <x-input-error :messages="$errors->get('max_membres')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="submit" class="px-10 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Enregistrer
                        </button>
                        <a href="{{ route('colocations.index')}}" type="submit" class="px-10 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </main>
@endsection
