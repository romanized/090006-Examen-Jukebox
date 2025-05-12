<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Hatchet</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @livewireStyles
</head>
<body>

<header>
    <div class="container flex-between">
        <a href="{{ route('home') }}" class="logo large-logo">The Hatchet Jukebox</a>

        <a href="{{ route('songs.admin') }}" class="btn">Admin login</a>
    </div>
</header>

<main class="container">
    @yield('content')
</main>

@livewireScripts
</body>
</html>
