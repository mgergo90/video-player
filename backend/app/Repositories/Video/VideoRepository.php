<?php

namespace App\Repositories\Video;

use App\Models\Video;
use Alaouy\Youtube\Youtube;
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
        $this->api = new Youtube(env('YOUTUBE_API_KEY', ''));
    }

    /**
     * Get all video with details.
     */
    public function all()
    {
        $videoIds = $this->model->all()->pluck('video_id');
        return Cache::remember(implode(",", $videoIds), env('REDIS_TTL', 10), function () {
            return collect($this->api->getVideoInfo($videoIds));
        });
    }
}
