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
    <div class="jukebox-wrapper">
        <div class="jukebox-left">
            <h2 class="jukebox-title">Muzieklijst</h2>
            <div class="song-list">
                @foreach($songs as $song)
                    <div class="song-item">
                        <button onclick="selectSong({{ $song->toJson() }})" class="song-button">
                            <strong>{{ $song->title }}</strong><br>
                            <small>{{ $song->artist }}</small>
                            <span class="song-plays">👁️ {{ $song->plays }}</span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="jukebox-right">
            <div id="player-box" class="song-player" style="display: none;">
                <div class="player-header">
                    <img id="song-cover" class="song-cover" alt="Cover">
                    <div class="player-meta">
                        <h3 id="song-title" class="song-title"></h3>
                        <p id="song-artist" class="song-artist"></p>
                        <p id="song-plays" class="song-playcount"></p>
                    </div>
                </div>

                <div class="player-audio-wrapper">
                    <audio id="song-audio" controls class="song-audio"></audio>
                </div>

                <form id="review-form" method="POST" class="review-form">
                    @csrf
                    <label for="name">Naam (optioneel)</label>
                    <input type="text" name="name" id="review-name" placeholder="Bijv. DJ Sander">

                    <label for="review-textarea">Review achterlaten</label>
                    <textarea name="review" id="review-textarea" required></textarea>
                    <button type="submit" class="btn">Verstuur</button>
                </form>

                <div id="review-box" class="review-box">
                    <h4>📣 Reviews</h4>
                    <ul id="song-reviews" class="review-list"></ul>
                </div>
            </div>

            <div id="placeholder-box" class="placeholder-box">
                <p>Selecteer een nummer aan de linkerkant om af te spelen.</p>
            </div>
        </div>
    </div>
</main>

<script>
    let playTimeout;

    function selectSong(song) {
        clearTimeout(playTimeout);

        document.getElementById('player-box').style.display = 'block';
        document.getElementById('placeholder-box').style.display = 'none';

        document.getElementById('song-cover').src = `/storage/${song.cover_image}`;
        document.getElementById('song-title').textContent = song.title;
        document.getElementById('song-artist').textContent = song.artist;
        document.getElementById('song-plays').textContent = `👁️ ${song.plays}x`;
        document.getElementById('song-audio').src = `/storage/${song.filename}`;
        document.getElementById('review-form').action = `/review/${song.id}`;

        const reviewList = document.getElementById('song-reviews');
        reviewList.innerHTML = '';
        if (song.reviews && song.reviews.length > 0) {
            song.reviews.forEach(r => {
                const li = document.createElement('li');
                const naam = r.name ? r.name : 'Gast';
                li.textContent = `${naam}: ${r.review}`;
                reviewList.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Nog geen reviews.';
            reviewList.appendChild(li);
        }

        document.getElementById('song-audio').play();

        playTimeout = setTimeout(() => {
            fetch(`/increment-play/${song.id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('song-plays').textContent = `👁️ ${data.plays}x`;
            });
        }, 5000);
    }

    // AJAX review zonder reload
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('review-form');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const actionUrl = form.getAttribute('action');
            const reviewText = formData.get('review');

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const ul = document.getElementById('song-reviews');
                const li = document.createElement('li');

                const naam = data.name ? data.name : 'Gast';
                const tijd = document.getElementById('song-audio').currentTime;
                const minuten = Math.floor(tijd / 60);
                const seconden = Math.floor(tijd % 60).toString().padStart(2, '0');

                li.textContent = `${naam}: ${data.review} - at ${minuten}:${seconden}`;
                ul.appendChild(li);
                form.reset();
            });
    });
});
</script>


@livewireScripts
</body>
</html>
