<nav class="bg-white shadow fixed top-0 w-full z-10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold">The Hatchet</a>
        @auth
            <a href="{{ route('songs.create') }}" class="text-sm text-pink-600">➕ Liedje toevoegen</a>
        @endauth
    </div>
</nav>
