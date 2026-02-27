@extends('layouts.app')

@section('content')
    <main class="m-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Mes Colocations
        </h2>
        <a href="{{ route('colocations.create') }}"
           class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        >
            <span>Créer Colocation</span>
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>


    </div>


    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        @forelse($colocations as $colocation)
            <div class="flex flex-col p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 border-t-4 border-purple-600 transition-transform hover:scale-105">
                <div class="flex items-center mb-4">
                    <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-200 uppercase truncate" style="max-width: 150px;">
                            {{ $colocation->nom }}
                        </p>
                        <span class="px-2 py-1 text-xs font-semibold leading-tight {{ $colocation->status == 'active' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }} rounded-full">
                    {{ $colocation->status }}
                </span>
                    </div>
                </div>

                <div class="mt-auto border-t pt-4 dark:border-gray-700">
                    @can('view', $colocation)
                    <a href="{{ route('colocations.show', $colocation) }}"
                       class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-purple-600 transition-colors duration-150 bg-transparent border border-purple-600 rounded-lg hover:bg-purple-600 hover:text-white focus:outline-none focus:shadow-outline-purple"
                    >
                        Gérer la Colocation
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                        @endcan
                </div>
                <div class="mt-auto border-t pt-4 dark:border-gray-700">
                    <a href="{{ route('invitations.invite', $colocation) }}"
                       class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-purple-600 transition-colors duration-150 bg-transparent border border-purple-600 rounded-lg hover:bg-purple-600 hover:text-white focus:outline-none focus:shadow-outline-purple"
                    >
                        Inviter des membres
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center p-8 bg-white rounded-lg dark:bg-gray-800">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">Vous ne faites partie d'aucune colocation pour le moment.</p>
            </div>
        @endforelse
    </div>
    </main>
@endsection
