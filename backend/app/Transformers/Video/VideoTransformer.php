<?php

namespace App\Transformers\Video;

use App\Transformers\TransformerInterface;
use League\Fractal\TransformerAbstract;

class VideoTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Video $response
     * @return array
     */
    public function transform($response): array
    {
        return [
            'id' => $response->id,
            'videoId' => $response->video_id,
            'playListId' => $response->play_list_id,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'videos';
    }
}
