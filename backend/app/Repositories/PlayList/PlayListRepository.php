<?php

namespace App\Repositories\PlayList;

use App\Models\PlayList;
use App\Repositories\RepositoryAbstract;

/**
 * Auction Repository
 */
class PlayListRepository extends RepositoryAbstract
{
    /**
     * Define model name.
     *
     * @return string
     */
    public function __construct(PlayList $model)
    {
        parent::__construct($model);
    }

    /**
     * Destroy playlist and all video in it.
     */
    public function destroy($model)
    {
        $model->videos()->delete();
        parent::destroy($model);
    }
}
