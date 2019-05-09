<?php

namespace App\Transformers\User;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Support\Arrayable;
use App\Transformers\TransformerInterface;

class UserTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\User $response
     * @return array
     */
    public function transform($response): array
    {
        return [
            'id' => $response->id,
            'email' => $response->email,
            'name' => $response->name,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'users';
    }
}
