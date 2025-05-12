<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['review', 'name'];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
