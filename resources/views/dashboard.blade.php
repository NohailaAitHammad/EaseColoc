@extends('layouts.app')
@section('content')

    <main class="m-8">
<div
    class="grid gap-6  md:grid-cols-2 xl:grid-cols-5">
    <!-- Card -->
    <div
        class="flex items-center p-10 bg-white rounded-lg shadow-xs dark:bg-gray-800"
    >
        <div
            class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
            </svg>


        </div>
        <div>
            <p
                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                Mon Scroe Reputation
            </p>
            <p
                class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
                {{ auth()->user()->reputation_score }}
            </p>
        </div>
    </div>
    <!-- Card -->
    <div
        class="flex items-center p-10 bg-white rounded-lg shadow-xs dark:bg-gray-800"
    >
        <div
            class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
        >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                    fill-rule="evenodd"
                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </div>
        <div>
            <p
                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                Depense Global
            </p>
            <p
                class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
                $ {{$depensesTotal}}
            </p>
        </div>
    </div>
    <!-- Card -->
    <div class="grid gap-6 mt-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($latestDepenses as $coloc)
            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition dark:bg-gray-800">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">{{ $coloc->nom }}</h3>
                <div class="flex flex-wrap gap-2 mb-2">
            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full dark:bg-blue-800 dark:text-blue-100">
                Membres: {{ $coloc->membership->whereNull('left_at')->count() }}
            </span>
                    <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full dark:bg-green-800 dark:text-green-100">
                Total Dépense: {{ $coloc->depenses()->sum('montant') }}
            </span>
                    <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-800 dark:text-yellow-100">
                Catégories: {{ $coloc->categories->count() }}
            </span>
                    <span class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded-full dark:bg-red-800 dark:text-red-100">
                Status: {{ $coloc->status }}
            </span>
                </div>
            </div>
        @endforeach
    </div>

</div>
    </main>
@endsection
