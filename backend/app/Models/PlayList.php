<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Video;
use App\Scopes\UserScope;

class PlayList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope);
    }

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
