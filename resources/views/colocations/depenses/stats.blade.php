@extends('layouts.app')

@section('content')
    <div class="p-6 bg-gray-100 min-h-screen">

        <h2 class="text-3xl font-bold mb-6">Statistiques & Dépenses - {{ $colocation->nom }}</h2>

        <!-- Filtre par mois -->
        <form method="GET" class="mb-6 flex items-center gap-3">
            <input type="month" name="month" value="{{ request('month') }}"
                   class="border rounded px-2 py-1">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Filtrer
            </button>
        </form>

        <!-- Tableau des dépenses -->
        <div class="bg-white shadow rounded-lg mb-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Titre</th>
                    <th class="px-4 py-2 text-left">Montant</th>
                    <th class="px-4 py-2 text-left">Catégorie</th>
                    <th class="px-4 py-2 text-center">Payée ?</th>
                    <th class="px-4 py-2 text-left">Membres</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($depenses as $depense)
                    <tr>
                        <td class="px-4 py-2">{{ $depense->title }}</td>
                        <td class="px-4 py-2">{{ $depense->montant }} MAD</td>
                        <td class="px-4 py-2">{{ $depense->categorie->name ?? 'Autre' }}</td>
                        <td class="px-4 py-2 text-center text-lg">
                            @if($depense->is_setled)
                                <span class="text-green-600">✅</span>
                            @else
                                <span class="text-red-600">❌</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @foreach($depense->users as $user)
                                <div>
                                    {{ $user->name ?? $user->firstName }} :
                                    <span class="{{ $user->pivot->status === 'payee' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $user->pivot->status === 'payee' ? '✅' : '❌' }}
                                </span>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Statistiques par catégorie -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h3 class="text-xl font-semibold mb-3">Total par catégorie</h3>
            <ul class="list-disc pl-5">
                @foreach($statsCategorie as $catName => $total)
                    <li>{{ $catName }} : {{ $total }} MAD</li>
                @endforeach
            </ul>
        </div>

        <!-- Statistiques mensuelles -->
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-xl font-semibold mb-3">Total par mois</h3>
            <ul class="list-disc pl-5">
                @foreach($statsMensuelles as $month => $total)
                    <li>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }} : {{ $total }} MAD</li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
