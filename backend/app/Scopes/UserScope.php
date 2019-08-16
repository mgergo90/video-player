<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserScope implements Scope
{
    /**
     * Only own playlist can be seen for users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('user_id', auth()->user()->id);
    }
}
