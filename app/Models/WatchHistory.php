<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

    protected $table = 'watch_histories';

    protected $guarded = [];

    public function scopeHistory($query, $param){
        return $query->where(
            ['movie_id' => $param['movie_id']],
            ['user_id' => $param['user_id']]
        )->first();
    }
}
