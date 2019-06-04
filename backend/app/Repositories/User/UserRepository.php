<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

/**
 * Auction Repository
 */
class UserRepository extends RepositoryAbstract
{
    /**
     * Define model name.
     *
     * @param User $model
     * @return void
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Store new user in database.
     *
     * @param array $data
     * @return User
     */
    public function store(array $data): Model
    {
        $userData = $data;
        $userData['data']['attributes']['password'] = Hash::make($data['data']['attributes']['password']);
        return parent::store($userData);
    }
}
