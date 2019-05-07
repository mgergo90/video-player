<?php

namespace App\Http\Requests\PlayList;

use App\Http\Requests\Auth\LoggedinRequest;

class PlayListDeleteRequest extends LoggedinRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return parent::authorize() && (int)$this->playList->user_id === auth()->user()->id;
    }
}
