<?php

namespace App\Transformers\Video;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Support\Arrayable;
use App\Transformers\TransformerInterface;

class YoutubeApiResponseTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param stdClass $response
     * @return array
     */
    public function transform($response): array
    {
        return [
            'id' => $response->id->videoId,
            'title' => $response->snippet->title,
            'description' => $response->snippet->description,
            'image' => $response->snippet->thumbnails->high->url,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'youtube-videos';
    }
}
