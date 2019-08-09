<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $credentials = $this->only('data.attributes.email', 'data.attributes.password')['data']['attributes'];
        return auth()->claims(['csrf-token' => str_random(32)])->attempt($credentials);
    }

    /**
     * Add validation rules that apply to the request.
     *
     * @return array
     */
    public function addRules(): array
    {
        return [
            'data.attributes' => 'required|array|size:2',
            'data.attributes.email' => 'required|email',
            'data.attributes.password' => 'required|string',
        ];
    }
}
