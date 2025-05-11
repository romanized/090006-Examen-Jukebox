<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::get('/', [SongController::class, 'index'])->name('home');
Route::post('/play/{song}', [SongController::class, 'play'])->name('play');
Route::post('/review/{song}', [SongController::class, 'addReview'])->name('review');
Route::post('/increment-play/{song}', [SongController::class, 'incrementPlay'])->name('increment.play');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/admin/songs/store', [SongController::class, 'store'])->name('songs.store');
});

require __DIR__.'/auth.php';
