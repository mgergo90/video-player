<?php

namespace App\Http\Controllers\YoutubeApi;

use App\Http\Controllers\ApiBaseController;
use App\Repositories\Video\YoutubeApiRepository;
use App\Transformers\Video\YoutubeApiResponseTransformer;
use App\Http\Requests\Request;
use App\Http\Requests\Video\YoutubeSearchRequest;

class YoutubeApiController extends ApiBaseController
{
    /**
     *  Set repository and transformer.
     *
     * @param YoutubeApiRepository $repository
     * @param YoutubeApiResponseTransformer $transformer
     * @return void
     */
    public function __construct(YoutubeApiRepository $repository, YoutubeApiResponseTransformer $transformer)
    {
        parent::__construct($repository, $transformer);
    }

    /**
     * Search on youtube.
     *
     * @param YoutubeSearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(YoutubeSearchRequest $request)
    {
        return $this->collection($this->repository->search($request->only('filter')));
    }
}
