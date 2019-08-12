<?php

namespace App\Http\Controllers\PlayList;

use App\Http\Controllers\ApiBaseController;
use App\Repositories\PlayList\PlayListRepository;
use App\Transformers\PlayList\PlayListTransformer;
use App\Http\Requests\PlayList\PlayListStoreRequest;
use App\Http\Requests\PlayList\PlayListUpdateRequest;
use App\Http\Requests\PlayList\PlayListDeleteRequest;
use App\Http\Requests\Auth\LoggedinRequest;
use App\Models\PlayList;
use Illuminate\Http\Response;

class PlayListController extends ApiBaseController
{
    /**
     * Set repository and transformer.
     *
     * @param PlayListRepository $repository
     * @param PlayListTransformer $transformer
     * @return void
     */
    public function __construct(PlayListRepository $repository, PlayListTransformer $transformer)
    {
        parent::__construct($repository, $transformer);
    }

    /**
     * List playlists.
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
     * Show playlist.
     *
     * @param LoggedinRequest $request
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function show(LoggedinRequest $request, PlayList $playList): Response
    {
        return $this->item($playList);
    }

    /**
     * Create playlist.
     *
     * @param PlayListStoreRequest $request
     * @return Response
     */
    public function store(PlayListStoreRequest $request): Response
    {
        return $this->item($this->repository->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Update playlist.
     *
     * @param PlayListUpdateRequest $request
     * @return Response
     */
    public function update(PlayListUpdateRequest $request, PlayList $playList): Response
    {
        return $this->item($this->repository->update($request->all(), $playList));
    }

    /**
     * Delete playlist.
     *
     * @param PlayListDeleteRequest $request
     * @param Playlist $playList
     * @return Response
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function destroy(PlayListDeleteRequest $request, PlayList $playList): Response
    {
        $this->repository->destroy($playList);
        return $this->null();
    }
}
