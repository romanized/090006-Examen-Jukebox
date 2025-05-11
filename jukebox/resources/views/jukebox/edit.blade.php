@extends('layouts.admin-layout')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Bewerk nummer</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('songs.update', $song) }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow border space-y-6">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
        <input type="text" name="title" value="{{ old('title', $song->title) }}" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Artiest</label>
        <input type="text" name="artist" value="{{ old('artist', $song->artist) }}" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nieuwe MP3 (optioneel)</label>
        <input type="file" name="filename" accept=".mp3" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nieuwe Cover (optioneel)</label>
        <input type="file" name="cover_image" accept="image/*" class="w-full border border-gray-300 rounded px-4 py-2">
    </div>

    <div>
        <p class="text-sm text-gray-600 mt-2">Aantal keer gekozen: <strong>{{ $song->plays }}</strong></p>
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded font-medium">
            Opslaan
        </button>
    </div>
</form>

@if ($song->reviews->count())
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Reviews</h3>
        <ul class="space-y-4">
            @foreach ($song->reviews as $review)
                <li class="bg-gray-100 rounded p-4 flex justify-between items-center">
                    <span class="text-sm text-gray-800">"{{ $review->review }}"</span>
                    <form action="{{ route('songs.reviews.destroy', [$song, $review]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">Verwijder</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
