<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Song;
use App\Models\Review;

class SongController extends Controller
{
    public function index()
    {
        $songs = \App\Models\Song::with('reviews')->get();
        return view('jukebox.index', compact('songs'));
    }
    
    public function play(Song $song)
    {
        $song->increment('plays');
        return response()->json(['success' => true]);
    }

    public function addReview(Request $request, Song $song)
    {
        $request->validate([
            'review' => 'required|string|max:255',
            'name' => 'nullable|string|max:100',
        ]);
    
        $review = $song->reviews()->create([
            'review' => $request->review,
            'name' => $request->name,
        ]);
    
        return response()->json([
            'success' => true,
            'review' => $review->review,
            'name' => $review->name,
            'created_at' => $review->created_at->diffForHumans(),
        ]);
    }
    
    

    public function create()
    {
        return view('jukebox.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'filename' => 'required|file|mimes:mp3',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $audioPath = $request->file('filename')->store('songs', 'public');
        $coverPath = $request->file('cover_image')->store('covers', 'public');

        Song::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'filename' => $audioPath,
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('home')->with('success', 'Liedje toegevoegd!');
    }

    public function incrementPlay(Song $song)
    {
        $song->increment('plays');
        return Response::json(['plays' => $song->plays]);
    }

    public function edit(Song $song)
{
    $song->load('reviews');
    return view('jukebox.edit', compact('song'));
}

    public function update(Request $request, Song $song)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'artist' => 'required|string|max:255',
        'filename' => 'nullable|file|mimes:mp3',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only('title', 'artist');

    if ($request->hasFile('filename')) {
        $data['filename'] = $request->file('filename')->store('songs', 'public');
    }

    if ($request->hasFile('cover_image')) {
        $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
    }

    $song->update($data);

    return redirect()->route('songs.admin')->with('success', 'Liedje bijgewerkt!');
}

    public function destroyReview(Song $song, Review $review)
    {
        if ($review->song_id !== $song->id) {
            abort(403);
    }

    $review->delete();
    return back()->with('success', 'Review verwijderd.');
    }

    public function adminIndex()
    {
    $songs = Song::orderByDesc('created_at')->get();
    return view('jukebox.admin-index', compact('songs'));
    }

}
