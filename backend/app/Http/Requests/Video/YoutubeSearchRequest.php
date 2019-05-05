<?php

namespace App\Http\Requests\Video;

use App\Http\Requests\Request;

class YoutubeSearchRequest extends Request
{
    /**
     * Add custom rules.
     *
     * @return array
     */
    protected function addRules(): array
    {
        return [
            'filter' => [
                'array',
            ],
            'filter.term' => 'string|required',
        ];
    }
}
