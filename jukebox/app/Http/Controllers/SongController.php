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
        $request->validate(['review' => 'required|string|max:255']);
        $song->reviews()->create(['review' => $request->review]);
        return back();
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

}
