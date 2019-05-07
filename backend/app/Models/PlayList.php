<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Video;

class PlayList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];

    /**
     * Owner of the play list.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Videos in the playlist.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
