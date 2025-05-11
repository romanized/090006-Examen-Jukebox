@extends('layouts.app-layout')

@section('content')
<div class="max-w-screen-xl mx-auto h-[85vh] grid grid-cols-1 md:grid-cols-2 gap-8 px-4">
    {{-- LINKERDEEL: Songlijst --}}
    <div class="bg-[#f9f9f6] border border-gray-200 rounded-xl shadow-sm overflow-y-auto">
        <div class="p-4 border-b border-gray-300">
            <h2 class="text-xl font-semibold text-gray-800">Muzieklijst</h2>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach($songs as $song)
                <li>
                    <button onclick="selectSong({{ $song->toJson() }})"
                        class="w-full text-left px-5 py-4 hover:bg-[#f0f0ed] transition flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $song->title }}</div>
                            <div class="text-sm text-gray-500">{{ $song->artist }}</div>
                        </div>
                        <div class="flex items-center gap-1 text-sm text-yellow-600">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.122-6.545L.489 6.91l6.563-.955L10 0l2.949 5.955 6.563.955-4.755 4.635 1.121 6.545z"/>
                            </svg>
                            <span>{{ $song->plays }}</span>
                        </div>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- RECHTERDEEL: Speler --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col justify-between">
        <div id="player-box" class="flex flex-col gap-5 hidden">
            <img id="song-cover" class="w-full h-56 object-cover rounded-xl border border-gray-300">
            <div>
                <h3 id="song-title" class="text-2xl font-bold text-gray-900"></h3>
                <p id="song-artist" class="text-gray-600 text-sm"></p>
                <p id="song-plays" class="text-sm text-yellow-600 mt-1"></p>
            </div>
            <audio id="song-audio" controls class="w-full rounded"></audio>

            <form id="review-form" method="POST" class="space-y-2 mt-4">
                @csrf
                <label class="block text-sm font-medium text-gray-700">Review</label>
                <textarea name="review" id="review-textarea" class="w-full border border-gray-300 rounded p-2" placeholder="Laat een review achter" required></textarea>
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded">
                    Verstuur
                </button>
            </form>

            <div id="review-box">
                <h4 class="font-semibold mt-4 text-gray-800">Reviews</h4>
                <ul id="song-reviews" class="text-sm text-gray-700 list-disc pl-5 space-y-1 mt-2"></ul>
            </div>
        </div>

        <div id="placeholder-box" class="text-center text-gray-400 my-auto">
            <p>Selecteer een nummer aan de linkerkant om af te spelen.</p>
        </div>
    </div>
</div>

<script>
    function selectSong(song) {
        document.getElementById('player-box').classList.remove('hidden');
        document.getElementById('placeholder-box').classList.add('hidden');

        document.getElementById('song-cover').src = `/storage/${song.cover_image}`;
        document.getElementById('song-title').textContent = song.title;
        document.getElementById('song-artist').textContent = song.artist;
        document.getElementById('review-form').action = `/review/${song.id}`;
        document.getElementById('song-audio').src = `/storage/${song.filename}`;

        // Fetch nieuwe 'plays' waarde
        fetch(`/increment-play/${song.id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('song-plays').textContent = `Gekozen: ${data.plays}x`;
        });

        // Reviews weergeven
        const reviewList = document.getElementById('song-reviews');
        reviewList.innerHTML = '';
        if (song.reviews && song.reviews.length > 0) {
            song.reviews.forEach(r => {
                const li = document.createElement('li');
                li.textContent = r.review;
                reviewList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Nog geen reviews.';
            reviewList.appendChild(li);
        }

        document.getElementById('song-audio').play();
    }
</script>
@endsection
