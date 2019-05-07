<?php

namespace App\Transformers\Video;

use App\Transformers\TransformerInterface;

class VideoTransformer extends YoutubeApiResponseTransformer implements TransformerInterface
{
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
