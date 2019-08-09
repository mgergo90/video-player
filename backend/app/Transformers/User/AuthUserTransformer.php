<?php

namespace App\Transformers\User;

use App\Transformers\TransformerInterface;
use JWTAuth;

class AuthUserTransformer extends UserTransformer implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param App\Models\User $user
     * @return array
     */
    public function transform($user): array
    {
        $data = parent::transform($user);
        $data['csrf_token'] = auth()->payload()->get('csrf-token');
        return $data;
    }
}
