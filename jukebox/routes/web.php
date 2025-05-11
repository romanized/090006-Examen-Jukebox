<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::get('/', [SongController::class, 'index'])->name('home');
Route::post('/play/{song}', [SongController::class, 'play'])->name('play');
Route::post('/review/{song}', [SongController::class, 'addReview'])->name('review');
Route::post('/increment-play/{song}', [SongController::class, 'incrementPlay'])->name('increment.play');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/songs', [SongController::class, 'adminIndex'])->name('songs.admin');
    Route::get('/admin/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/admin/songs/store', [SongController::class, 'store'])->name('songs.store');
    Route::get('/admin/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
    Route::put('/admin/songs/{song}', [SongController::class, 'update'])->name('songs.update');
    Route::delete('/admin/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');
    Route::delete('/admin/songs/{song}/reviews/{review}', [SongController::class, 'destroyReview'])->name('songs.reviews.destroy');
});

require __DIR__.'/auth.php';
