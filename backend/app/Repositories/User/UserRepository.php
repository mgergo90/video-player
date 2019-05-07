<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\Hash;

/**
 * Auction Repository
 */
class UserRepository extends RepositoryAbstract
{
    /**
     * Define model name.
     *
     * @return string
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Store new user in database.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        return parent::store($data + [
            'data' => [
                'attributes' => [
                    'password' => Hash::make($data['data']['attributes']['password'])
                ]
            ]
        ]);
    }
}
