
@extends('layouts.admin-layout')

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <h2 class="admin-title">Admin Paneel - Liedjesbeheer</h2>
        <div class="admin-actions">
            <a href="{{ route('home') }}" class="btn btn-secondary">Publieke homepage</a>
            <a href="{{ route('songs.create') }}" class="btn btn-primary">Nieuw nummer</a>
        </div>
    </div>

    @if (session('success'))
    <div class="alert-success" id="flash-message">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) flash.style.display = 'none';
        }, 4000); // verdwijnt na 4 seconden
    </script>
    @endif

    @foreach ($songs as $song)
        <div class="admin-song-card">
            <img src="{{ asset('storage/' . $song->cover_image) }}" alt="Cover" class="admin-song-cover">

            <div class="admin-song-info">
                <div>
                    <h3 class="admin-song-title">{{ $song->title }}</h3>
                    <p class="admin-song-artist">{{ $song->artist }}</p>
                    <p class="admin-song-plays">👁️ {{ $song->plays }}x afgespeeld</p>
                </div>

                <div class="admin-song-actions-column">
                    <a href="{{ route('songs.edit', $song) }}" class="btn btn-blue">Bewerk</a>
                    <form action="{{ route('songs.destroy', $song) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit nummer wilt verwijderen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Verwijder</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
