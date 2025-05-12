<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>The Hatchet - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    <header class="bg-gray-900 text-white shadow">
        <div class="max-w-screen-xl mx-auto py-4 px-6 flex justify-between items-center">
            <h1 class="text-lg font-semibold">🎛️ Admin Beheer</h1>
            <a href="{{ route('home') }}" class="text-sm underline hover:text-pink-400">Terug naar homepage</a>
        </div>
    </header>

    <main class="flex-grow py-8 px-6">
        @yield('content')
    </main>

    <footer class="bg-white text-center py-4 text-sm text-gray-400 border-t">
        &copy; {{ date('Y') }} The Hatchet - Nebi Canlioglu
    </footer>

    @livewireScripts
</body>
</html>
