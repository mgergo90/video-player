<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoggedinRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user() !== null;
    }
}
