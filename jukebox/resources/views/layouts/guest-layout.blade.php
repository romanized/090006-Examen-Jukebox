<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>The Hatchet</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @livewireStyles
</head>
<body class="bg-[#f5f5f4] text-gray-900 min-h-screen flex flex-col">

    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-gray-800">🎧 The Hatchet Jukebox</a>

            @auth
                <a href="{{ route('songs.create') }}"
                   class="bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium px-4 py-2 rounded transition">
                    Nieuw nummer toevoegen
                </a>
            @endauth
        </div>
    </header>

    <main class="flex-grow py-8">
        @yield('content')
    </main>

    <footer class="bg-white text-center py-5 text-sm text-gray-500 border-t border-gray-200">
        &copy; {{ date('Y') }} The Hatchet. Gemaakt met ❤️ in Rotterdam.
    </footer>

    @livewireScripts
</body>
</html>
