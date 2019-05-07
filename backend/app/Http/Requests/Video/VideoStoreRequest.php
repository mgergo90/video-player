<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\Auth\LoggedinRequest;

class VideoStoreRequest extends LoggedinRequest
{
    /**
     * Add custom rules.
     *
     * @return array
     */
    protected function addRules(): array
    {
        return [
            'data.attributes' => [
                'required',
                'array',
                'bail',
                'attribute_keys:' .
                implode(',', [
                    'video_id',
                    'play_list_id',
                ])
            ],
            'data.attributes.video_id' => 'required|string|max:255',
            'data.attributes.play_list_id' => 'exists:play_lists,id',
        ];
    }
}
