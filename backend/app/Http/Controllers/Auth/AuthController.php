<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoggedinRequest;
use App\Http\Requests\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\User\UserRepository;
use App\Transformers\User\AuthUserTransformer;
use Illuminate\Http\Response;

class AuthController extends ApiBaseController
{
    /**
     * Set repository and transformer.
     *
     * @param UserRepository $repository
     * @param AuthUserTransformer $transformer
     * @return void
     */
    public function __construct(UserRepository $repository, AuthUserTransformer $transformer)
    {
        parent::__construct($repository, $transformer);
    }

    /**
     * Return authenticated user.
     *
     * @param LoginRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function login(LoginRequest $request): Response
    {
        return $this->item(auth()->user())
            ->withCookie('token', auth()->getToken()->get(), config('jwt.ttl'), "/");
    }

    /**
     * Return current user.
     *
     * @param LoggedinRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function getUser(LoggedinRequest $request): Response
    {
        return $this->item(auth()->user());
    }

    /**
     * Logout current user.
     *
     * @param LoggedinRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function logout(LoggedinRequest $request): Response
    {
        auth()->logout();
        return $this->null();
    }
}
