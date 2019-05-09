<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\ApiBaseController;
use App\Repositories\Video\VideoRepository;
use App\Transformers\Video\VideoTransformer;
use App\Http\Requests\Video\VideoStoreRequest;
use App\Http\Requests\Auth\LoggedinRequest;
use App\Models\Video;
use Illuminate\Http\Response;
use App\Events\NewVideoEvent;

class VideoController extends ApiBaseController
{
    /**
     * Set repository and transformer.
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
     * List videos.
     *
     * @param LoggedinRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function index(LoggedinRequest $request): Response
    {
        return $this->collection($this->repository->collect());
    }

    /**
     * Create video.
     *
     * @param VideoStoreRequest $request
     * @return Response
     */
    public function store(VideoStoreRequest $request): Response
    {
        $video = $this->repository->store($request->all());
        $data = $this->transformer->transform($video);
        broadcast(new NewVideoEvent($video, $data));
        return $this->null(Response::HTTP_CREATED);
    }

    /**
     * Delete video.
     *
     * @param LoggedinRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function destroy(LoggedinRequest $request, Video $video): Response
    {
        $this->repository->destroy($video);
        return $this->null();
    }
}
