<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiBaseController;
use App\Repositories\User\UserRepository;
use App\Transformers\User\UserTransformer;
use App\Http\Requests\User\UserStoreRequest;
use Illuminate\Http\Response;

class UserController extends ApiBaseController
{
    /**
     * Set repository and transformer.
     *
     * @param UserRepository $repository
     * @param UserTransformer $transformer
     * @return void
     */
    public function __construct(UserRepository $repository, UserTransformer $transformer)
    {
        parent::__construct($repository, $transformer);
    }

    /**
     * Create user.
     *
     * @param UserStoreRequest $request
     * @return Response
     */
    public function store(UserStoreRequest $request): Response
    {
        return $this->item($this->repository->store($request->all()), Response::HTTP_CREATED);
    }
}
