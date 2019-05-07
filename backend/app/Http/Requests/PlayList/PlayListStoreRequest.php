<?php

namespace App\Http\Requests\PlayList;

use App\Http\Requests\Auth\LoggedinRequest;

class PlayListStoreRequest extends LoggedinRequest
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
                    'name',
                    'user_id',
                ])
            ],
            'data.attributes.name' => 'required|string|max:255',
            'data.attributes.user_id' => 'in:' . auth()->user()->id,
        ];
    }
}
