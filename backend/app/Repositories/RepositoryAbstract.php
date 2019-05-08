<?php

/**
 * Base repository.
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Base Repository.
 */
abstract class RepositoryAbstract
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Create model.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Collect items.
     *
     * @param array $filter
     * @param array $sort
     *
     * @return Collection
     */
    public function collect($filter = [], $sort = [])
    {
        return $this->applyFilter($filter)->applySort($sort)->model->get();
    }

    /**
     * Paginate items.
     *
     * @param array $filter
     * @param array $sort
     * @param array $page
     *
     * @return Collection
     */
    public function paginate($filter, $sort, $page)
    {
        $paginated = $this->applyFilter($filter)
            ->applySort($sort)
            ->model
            ->paginate($page['size'], ['*'], 'page.number');
        $paginated->appends('filter', $filter);
        $paginated->appends('sort', $sort);
        $paginated->appends('page', $page);
        return $paginated;
    }

    /**
     * Filter items.
     *
     * @param string $field
     * @param string $value
     *
     * @return RepositoryAbstract
     * @SuppressWarnings(UnusedFormalParameter)
     */
    protected function filter($field, $value)
    {
        $this->model = $this->model->where($field, 'like', "%${value}%");
        return $this;
    }

    /**
     * Apply filter options.
     *
     * @param array $filter
     *
     * @return RepositoryAbstract
     */
    protected function applyFilter($filter)
    {
        foreach ($filter as $field => $value) {
            $this->filter($field, $value);
        }
        return $this;
    }

    /**
     * Sort items.
     *
     * @param string $field
     * @param string $sort
     *
     * @return RepositoryAbstract
     */
    protected function sort($field, $sort)
    {
        $this->model = $this->model->orderBy($field, $sort);
        return $this;
    }

    /**
     * Apply sort options.
     *
     * @param array $sort
     *
     * @return RepositoryAbstract
     */
    protected function applySort($sort)
    {
        foreach ($sort as $field => $order) {
            $this->sort($field, $order);
        }
        return $this;
    }

    /**
     * Store item in database.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        $this->model = $this->model->create($data['data']['attributes']);
        return $this->model;
    }

    /**
     * Store item in database.
     *
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, $model)
    {
        $model->fill($data['data']['attributes'])->save();
        return $model;
    }

    /**
     * Delete item from database.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy($model)
    {
        $model->delete();
        return $model;
    }
}
