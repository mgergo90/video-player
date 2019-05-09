<?php

namespace App\Repositories\Video;

use App\Models\Video;
use App\Repositories\RepositoryAbstract;

/**
 * Auction Repository
 */
class VideoRepository extends RepositoryAbstract
{
    /**
     * Define model name.
     *
     * @param Video $model
     * @return viod
     */
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }
}
