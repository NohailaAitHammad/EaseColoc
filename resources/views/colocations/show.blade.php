@extends('layouts.app')
@section('content')
{{ $colocation }}
<div class="container px-6 mx-auto grid">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center my-6 gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 uppercase">
                 colocation->nom  [cite: 20, 21]
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Statut :
                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                     colocation->status  [cite: 2, 3, 22]
                </span>
            </p>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                + Nouvelle dépense [cite: 101]
            </button>
            <button class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-600 hover:text-white">
                Annuler la colocation [cite: 119]
            </button>
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-3">
        <div class="md:col-span-2 space-y-6">
            <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800 p-4">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">Historique des Dépenses [cite: 102]</h4>
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Titre / Catégorie [cite: 7, 13]</th>
                            <th class="px-4 py-3">Montant [cite: 12]</th>
                            <th class="px-4 py-3">Payeur [cite: 16, 55]</th>
                            <th class="px-4 py-3">Date [cite: 17]</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                        @foreach($colocation->depenses as $depense)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    <p class="font-semibold"> depense->titre  [cite: 13]</p>
                                    <span class="text-xs text-purple-600"> depense->categorie->nom  [cite: 7, 14]</span>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold"> depense->montant  € [cite: 12]</td>
                                <td class="px-4 py-3 text-sm"> depense->payeur->firstName  [cite: 16, 55]</td>
                                <td class="px-4 py-3 text-sm"> depense->date  [cite: 17]</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 border-l-4 border-orange-500">
                <h4 class="mb-2 font-semibold text-gray-600 dark:text-gray-300">Qui doit à qui ? [cite: 109]</h4>
                <div class="text-sm text-gray-600 dark:text-gray-400 italic">
                    Aucun remboursement en attente. [cite: 75]
                </div>
            </div>

            <div class="p-4 bg-gray-900 rounded-lg shadow-xs text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold uppercase text-xs tracking-wider">Membres de la coloc [cite: 28]</h4>
                    <span class="text-xs bg-gray-700 px-2 py-1 rounded">ACTIFS</span>
                </div>
                <div class="space-y-4">
                    @foreach($colocation->memberships as $membership)
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
                    @endforeach
                </div>
                <button class="w-full mt-6 py-2 text-xs font-semibold bg-gray-800 border border-gray-700 rounded hover:bg-gray-700 transition-colors">
                    + Inviter un membre [cite: 114]
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
