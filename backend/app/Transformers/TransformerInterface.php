<?php

namespace App\Transformers;

/**
 * Transformer interface.
 */
interface TransformerInterface
{

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string;

    /**
     * Transform object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    public function transform($model): array;
}
