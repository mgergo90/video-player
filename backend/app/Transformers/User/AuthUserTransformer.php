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
        $token = JWTAuth::fromUser($user);
        $data['access_token'] = $token;
        $data['token_type'] = 'bearer';
        return $data;
    }
}
