<?php

namespace App\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Serializer\JsonApiSerializer;
use Illuminate\Http\Request;

class Fractal
{
    /**
     * @var Manager
     */
    protected $manager;

    public function __construct()
    {
        $this->manager = new Manager();
        $this->manager->setSerializer(new JsonApiSerializer(env('APP_URL', null) . '/api'));
    }

    /**
     * Get collection of data.
     *
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function collection($collection, $transformer, $resourceKey)
    {
        return $this->transform('League\Fractal\Resource\Collection', $collection, $transformer, $resourceKey);
    }

    /**
     * Get collection of data.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function item($model, $transformer, $resourceKey)
    {
        return $this->transform('League\Fractal\Resource\Item', $model, $transformer, $resourceKey);
    }

    /**
     * Null response.
     *
     * @return string
     */
    public function null(): string
    {
        $resource = new NullResource();
        return $this->manager->createData($resource)->toJson();
    }

    /**
     * Pagination.
     *
     * @param \Illuminate\Support\Collection $collection
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     */
    public function pagination($collection, $transformer, $resourceKey)
    {
        return $this->transform('League\Fractal\Resource\Collection', $collection, $transformer, $resourceKey);
    }

    /**
     * Transform data.
     *
     * @param string $resourceType
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection $data
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @return mixed
     */
    protected function transform($resourceType, $data, $transformer, $resourceKey)
    {
        $paginator = null;
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $paginator = $data;
            $data = $data->getCollection();
        }
        $resource = app()->makeWith($resourceType, [
            'data' => $data,
            'transformer' => $transformer,
            'resourceKey' => $resourceKey,
        ]);
        if ($paginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        }
        return $this->manager->createData($resource)->toJson();
    }
}
