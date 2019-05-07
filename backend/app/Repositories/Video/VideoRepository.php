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
     * @return string
     */
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }
}
