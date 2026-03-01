<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold mb-2">Invitation colocation</h2>
        <p class="text-gray-700 mb-4">Vous êtes invité à rejoindre <strong>{{ $payload['colocation_name'] ?? 'la colocation' }}</strong></p>

        <form action="{{ route('invitations.accept', $token) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                Accepter l'invitation
            </button>
        </form>

        <form action="{{ route('invitations.decline', $token) }}" method="POST">
            @csrf
            <button type="submit" class="text-red-600 hover:underline">
                Décliner
            </button>
        </form>
    </div>
</div>
</body>
</html>
