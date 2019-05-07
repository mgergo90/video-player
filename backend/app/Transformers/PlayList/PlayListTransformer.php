<?php

namespace App\Transformers\PlayList;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Support\Arrayable;
use App\Transformers\TransformerInterface;

class PlayListTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\PlayList $response
     * @return array
     */
    public function transform($response): array
    {
        return [
            'id' => $response->id,
            'name' => $response->name,
            'user_id' => $response->user_id,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'play-lists';
    }
}
