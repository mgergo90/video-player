<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoggedinRequest;
use App\Http\Requests\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\User\UserRepository;
use App\Transformers\User\AuthUserTransformer;

class AuthController extends ApiBaseController
{
    /**
     *  Set repository and transformer.
     *
     * @param YoutubeApiRepository $repository
     * @param YoutubeApiResponseTransformer $transformer
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
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function login(LoginRequest $request)
    {
        return $this->item(auth()->user());
    }

    /**
     * Return current user.
     *
     * @param LoggedinRequest $request
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function getUser(LoggedinRequest $request)
    {
        return $this->item(auth()->user());
    }

    /**
     * Logout current user.
     *
     * @param LoggedinRequest $request
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function logout(LoggedinRequest $request)
    {
        auth()->logout();
        return $this->null();
    }
}
