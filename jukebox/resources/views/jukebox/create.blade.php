@extends('layouts.admin-layout')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Nieuw nummer toevoegen</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow border space-y-6">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Titel van het nummer</label>
        <input type="text" name="title" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-pink-600" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Naam van de artiest</label>
        <input type="text" name="artist" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-pink-600" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">MP3-bestand</label>
        <input type="file" name="filename" accept=".mp3" class="w-full border border-gray-300 rounded px-4 py-2 bg-white" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Cover-afbeelding</label>
        <input type="file" name="cover_image" accept="image/*" class="w-full border border-gray-300 rounded px-4 py-2 bg-white" required>
    </div>

    <div class="pt-4">
        <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded font-medium">
            Toevoegen
        </button>
    </div>
</form>
@endsection
