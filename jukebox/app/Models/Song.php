<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'filename',
        'cover_image',
        'plays',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
