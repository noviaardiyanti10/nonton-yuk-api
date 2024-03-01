<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'title',
        'movie',
        'categories',
        'min_age_req',
        'small_thumbnail',
        'large_thumbnail',
        'release_date',
        'about',
        'duration',
    ];
}
