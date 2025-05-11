@extends('layouts.admin-layout')

@section('content')
<div class="max-w-screen-lg mx-auto px-4 space-y-10">
    <div class="flex justify-between items-center border-b pb-4">
        <h2 class="text-3xl font-bold text-gray-800">Admin Paneel - Liedjesbeheer</h2>
        <div class="space-x-3">
            <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-sm px-4 py-2 rounded border text-gray-700 shadow-sm">Publieke homepage</a>
            <a href="{{ route('songs.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white text-sm px-4 py-2 rounded shadow">Nieuw nummer</a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($songs as $song)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col md:flex-row gap-5">
            <img src="{{ asset('storage/' . $song->cover_image) }}" class="w-32 h-32 object-cover rounded border">

            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $song->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $song->artist }}</p>
                    <p class="text-xs text-yellow-600 mt-1">Gekozen: {{ $song->plays }}x</p>
                </div>
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('songs.edit', $song) }}" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Bewerk</a>
                    <form action="{{ route('songs.destroy', $song) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit nummer wilt verwijderen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Verwijder</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
