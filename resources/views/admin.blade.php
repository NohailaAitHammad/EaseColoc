@extends('layouts.app')

@section('content')

    <div class="p-6 bg-gray-100 min-h-screen">

        <!-- Statistiques globales -->
        <div class="bg-white shadow p-6 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold mb-4">Statistiques Globales</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded text-center">
                    <div class="text-xl font-bold">{{ $stats['users'] }}</div>
                    <div>Utilisateurs</div>
                </div>
                <div class="bg-green-100 p-4 rounded text-center">
                    <div class="text-xl font-bold">{{ $stats['colocations'] }}</div>
                    <div>Colocations</div>
                </div>
                <div class="bg-yellow-100 p-4 rounded text-center">
                    <div class="text-xl font-bold">{{ $stats['depenses'] }} MAD</div>
                    <div>Dépenses Totales</div>
                </div>
            </div>
        </div>

        <!-- Gestion utilisateurs -->
        <div class="bg-white shadow p-6 rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Gestion des Utilisateurs</h2>
            @if(session('success'))
                <div class="bg-green-200 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif

            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Prenom</th>
                    <th class="p-2">Nom</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="border-b">
                        <td class="p-2">{{ $user->firstName }}</td>
                        <td class="p-2">{{ $user->lastName }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">
                            @if($user->is_banned === 1)
                                <span class="text-red-600 font-bold">Banni</span>
                            @else
                                <span class="text-green-600 font-bold">Actif</span>
                            @endif
                        </td>
                        <td class="p-2">
                            <form action="{{ route('admin.toggleBan', $user) }}" method="POST">
                                @csrf
                                @if($user->is_banned === 1)
                                <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded">
                                    Débannir
                                </button>
                                @else
                                    <button type="submit"
                                            class="bg-red-500  text-white px-3 py-1 rounded">
                                        Bannir
                                    </button>
                                    @endif

                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
