@extends('layouts.admin-layout')

@section('content')
<div class="form-wrapper">
    <div class="form-header">
        <h2>Nieuw nummer toevoegen</h2>
        <a href="{{ route('songs.admin') }}" class="form-btn form-btn-secondary">← Terug naar dashboard</a>
    </div>


    @if ($errors->any())
        <div class="alert-box">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data" class="form-panel">
        @csrf

        <label>Titel</label>
        <input type="text" name="title" required>

        <label>Artiest</label>
        <input type="text" name="artist" required>

        <label>MP3-bestand</label>
        <input type="file" name="filename" accept=".mp3" required>

        <label>Cover afbeelding</label>
        <input type="file" name="cover_image" accept="image/*" required>

        <button type="submit" class="btn btn-primary">Toevoegen</button>
    </form>
</div>
@endsection
