@extends('layouts.admin-layout')

@section('content')
<div class="form-wrapper">
    <div class="form-header">
        <h2>Bewerk nummer</h2>
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

    <form action="{{ route('songs.update', $song) }}" method="POST" enctype="multipart/form-data" class="form-panel">
        @csrf
        @method('PUT')

        <label>Titel</label>
        <input type="text" name="title" value="{{ old('title', $song->title) }}">

        <label>Artiest</label>
        <input type="text" name="artist" value="{{ old('artist', $song->artist) }}">

        <label>Nieuwe MP3 (optioneel)</label>
        <input type="file" name="filename" accept=".mp3">

        <label>Nieuwe Cover (optioneel)</label>
        <input type="file" name="cover_image" accept="image/*">

        <p class="text-sm text-gray-600 mt-2">Aantal keer gekozen: <strong>{{ $song->plays }}</strong></p>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>

    @if ($song->reviews->count())
        <div class="review-list">
            <h3>Reviews</h3>
            <ul>
                @foreach ($song->reviews as $review)
                    <li>
                        "{{ $review->review }}"
                        <form action="{{ route('songs.reviews.destroy', [$song, $review]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Verwijder</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
