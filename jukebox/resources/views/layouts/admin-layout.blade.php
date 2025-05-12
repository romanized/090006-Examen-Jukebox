<!-- resources/views/layouts/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>The Hatchet - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/songform.css') }}">
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    <header class="bg-gray-900 text-white shadow">
        <div class="max-w-screen-xl mx-auto py-4 px-6 flex justify-between items-center">
            <h1 class="text-lg font-semibold">The Hatchet</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </header>

    <main class="flex-grow py-8 px-6">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
