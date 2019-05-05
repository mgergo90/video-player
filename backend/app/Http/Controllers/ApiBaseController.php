<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Transformers\Fractal;
use League\Fractal\TransformerAbstract;
use App\Repositories\RepositoryAbstract;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * BaseController for API.
 */
abstract class ApiBaseController extends Controller
{
    /**
     * @var Fractal
     */
    protected $fractal;

    /**
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * @var RepositoryAbstract
     */
    protected $repository;

    /**
     * Create a new ApiBaseController instance.
     */
    public function __construct(RepositoryAbstract $repository, TransformerAbstract $transformer)
    {
        $this->fractal = new Fractal();
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * Return with one resource item.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function item($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->item($resource, $this->transformer, $this->transformer->getResourceKey());
        return $this->response($response, $status);
    }

    /**
     * Return with one resource item.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function null($status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->null();
        return $this->response($response, $status);
    }

    /**
     * Return with multiple resource items.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function collection($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->collection($resource, $this->transformer, $this->transformer->getResourceKey());
        return $this->response($response, $status);
    }

    /**
     * Return with paginated resource items.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param integer|null $status
     * @return \Illuminate\Http\Response
     */
    protected function pagination($resource, $status = Response::HTTP_OK): Response
    {
        $response = $this->fractal->pagination($resource, $this->transformer, $this->transformer->getResourceKey());
        $response = str_replace('page.size', 'page[size]', $response);
        $response = str_replace('page.number', 'page[number]', $response);
        return $this->response($response, $status);
    }

    /**
     * Set transformer.
     *
     * @param TransformerAbstract $transformer
     */
    protected function setTransformer(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Json response.
     *
     * @param $data string
     * @param $status integer
     * @return Illuminate\Http\Response
     */
    protected function response($data, $status): Response
    {
        return response($data, $status)->header('Content-Type', 'application/json');
    }
}
