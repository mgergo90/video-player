<?php

namespace App\Repositories\Video;

use Alaouy\Youtube\Youtube;
use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\Cache;

/**
 * Auction Repository
 */
class YoutubeApiRepository extends RepositoryAbstract
{
    /**
     * @var Youtube
     */
    protected $api;

    /**
     * Define model name.
     */
    public function __construct()
    {
        $this->api = new Youtube(env('YOUTUBE_API_KEY', ''));
    }

    /**
     * Search videos on youtube.
     *
     * @param array $data
     * @return array
     */
    public function search(array $data): array
    {
        $term = $data['filters']['term'];
        return Cache::remember(base64_encode($term), env('REDIS_TTL', 10), function () use ($term) {
            return collect($this->api->search($term, 20))
                ->filter(function ($value) {
                    return $value->id->kind === 'youtube#video';
                })
                ->all();
        });
    }
}
