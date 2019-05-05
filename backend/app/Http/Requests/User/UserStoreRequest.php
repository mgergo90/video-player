<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserStoreRequest extends Request
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
                    'password',
                    'password_confirmation',
                    'email',
                ])
            ],
            'data.attributes.name' => 'required|string|max:255|unique:users,name',
            'data.attributes.email' => 'required|email|max:255|unique:users,name',
            'data.attributes.password' => 'required|string|min:6|max:255|confirmed',
        ];
    }
}
