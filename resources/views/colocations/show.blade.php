@extends('layouts.app')
@section('content')

<div class="container px-6 mx-auto grid">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-6 gap-4">

        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 uppercase">
                {{$colocation->nom }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Statut :
                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                     {{$colocation->status}}
                </span>
            </p>
        </div>

        <div class="  flex gap-2">
            <a href="{{ route('colocations.depenses.create', $colocation) }}" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                + Nouvelle dépense
            </a>
            <a href="{{ route('colocations.categories.create', $colocation) }}" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                + Nouvelle category
            </a>
            @can('update', $colocation)
            <a href="{{ route('colocations.cancel', $colocation) }}" class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-600 hover:text-white">
                Annuler la colocation
            </a>
            @endcan
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-3">
        <div class="md:col-span-2 space-y-6">
            <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800 p-4">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">Historique des Dépenses </h4>
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Titre / Catégorie</th>
                            <th class="px-4 py-3">Montant</th>
                            <th class="px-4 py-3">Payeur </th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                        @foreach($colocation->depenses as $depense)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    <p class="font-semibold"> {{$depense->title}} </p>
                                    <span class="text-xs text-purple-600"> {{$depense->categorie->nom}}</span>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold"> {{$depense->montant }} € </td>
                                <td class="px-4 py-3 text-sm"> {{$depense->payeur->firstName}} </td>
                                <td class="px-4 py-3 text-sm">{{ $depense->date}} </td>

                                <td class="px-4 py-3 text-sm"><div class="flex items-center space-x-4 text-sm">
                                        @can('update', $depense)
                                        <a href="{{route('colocations.depenses.edit',[$colocation, $depense])}}"
                                           class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                           aria-label="Edit"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                aria-hidden="true"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                                ></path>
                                            </svg>
                                        </a>
                                        @endcan
                                        @can('delete', $depense)
                                        <form action="{{ route('colocations.depenses.destroy',[$colocation, $depense]) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete" type="submit"
                                            >
                                                <svg
                                                    class="w-5 h-5"
                                                    aria-hidden="true"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"
                                                    ></path>
                                                </svg>
                                            </button>
                                        </form>
                                            @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $colocation->$depense->links() }}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 border-l-4 border-orange-500">
                <h4 class="mb-2 font-semibold text-gray-600 dark:text-gray-300">Qui doit à qui ?</h4>
                <div class="text-sm text-gray-600 dark:text-gray-400 italic">
                    Aucun remboursement en attente.
                </div>
            </div>

            <div class="p-4 bg-gray-900 rounded-lg shadow-xs text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold uppercase text-xs tracking-wider">Membres de la coloc [cite: 28]</h4>
                    <span class="text-xs bg-gray-700 px-2 py-1 rounded">ACTIFS</span>
                </div>
                <div class="space-y-4">
                    {{--@foreach($colocation->memberships as $membership)--}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded bg-gray-700 flex items-center justify-center text-xs font-bold">
                                     substr(membership->user->firstName, 0, 1)  [cite: 55]
                                </div>
                                <div>
                                    <p class="text-sm font-medium"> membership->user->firstName  [cite: 30, 55]</p>
                                    <p class="text-xs text-orange-400">👑  membership->role  [cite: 33, 45]</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-green-400"> membership->user->reputation_score  [cite: 64]</span>
                        </div>

                </div>
                <a href="{{ route('invitations.invite', $colocation) }}" class="w-full mt-6 py-2 text-xs font-semibold bg-gray-800 border border-gray-700 rounded hover:bg-gray-700 transition-colors">
                    + Inviter un membre
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
