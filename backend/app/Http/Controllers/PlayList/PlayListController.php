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
use Illuminate\Http\JsonResponse;

class PlayListController extends ApiBaseController
{
    /**
     *  Set repository and transformer.
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
     * @return \Illuminate\Http\Response
     */
    public function index(LoggedinRequest $request)
    {
        return $this->collection($this->repository->collect());
    }

    /**
     * Create playlist.
     *
     * @param PlayListStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayListStoreRequest $request)
    {
        return $this->item($this->repository->store($request->all()), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update playlist.
     *
     * @param PlayListUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PlayListUpdateRequest $request, PlayList $playList)
    {
        return $this->item($this->repository->update($request->all(), $playList));
    }

    /**
     * Delete playlist.
     *
     * @param PlayListDeleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayListDeleteRequest $request, PlayList $playList)
    {
        $this->repository->destroy($playList);
        return $this->null();
    }
}
