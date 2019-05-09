<?php

namespace App\Repositories\PlayList;

use App\Models\PlayList;
use App\Repositories\RepositoryAbstract;
use Illuminate\Database\Eloquent\Model;

class PlayListRepository extends RepositoryAbstract
{
    /**
     * Define model name.
     *
     * @param PlayList $model
     * @return void
     */
    public function __construct(PlayList $model)
    {
        parent::__construct($model);
    }

    /**
     * Destroy playlist and all video in it.
     *
     * @param PlayList $model
     * @return Playlist
     */
    public function destroy($model): Model
    {
        $model->videos()->delete();
        return parent::destroy($model);
    }
}
