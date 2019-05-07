<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\ApiBaseController;
use App\Repositories\Video\VideoRepository;
use App\Transformers\Video\VideoTransformer;
use App\Http\Requests\Video\VideoStoreRequest;
use App\Http\Requests\Auth\LoggedinRequest;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class VideoController extends ApiBaseController
{
    /**
     *  Set repository and transformer.
     *
     * @param VideoRepository $repository
     * @param VideoTransformer $transformer
     * @return void
     */
    public function __construct(VideoRepository $repository, VideoTransformer $transformer)
    {
        parent::__construct($repository, $transformer);
    }

    /**
     * List playlists.
     *
     * @param LoggedinRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(LoggedinRequest $request)
    {
        return $this->collection($this->repository->collect());
    }

    /**
     * Create video.
     *
     * @param VideoStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoStoreRequest $request)
    {
        $this->repository->store($request->all());
        return $this->null(JsonResponse::HTTP_CREATED);
    }

    /**
     * Delete video.
     *
     * @param PlayListDeleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoggedinRequest $request, Video $video)
    {
        $this->repository->destroy($video);
        return $this->null();
    }
}
