<?php

/**
 * Base repository.
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
     *
     * @param Model $model
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
     * @return Collection
     */
    public function collect($filter = [], $sort = []): Collection
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
    public function paginate($filter, $sort, $page): Collection
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
     * @return RepositoryAbstract
     * @SuppressWarnings(UnusedFormalParameter)
     */
    protected function filter($field, $value): RepositoryAbstract
    {
        $this->model = $this->model->where($field, 'like', "%${value}%");
        return $this;
    }

    /**
     * Apply filter options.
     *
     * @param array $filter
     * @return RepositoryAbstract
     */
    protected function applyFilter($filter): RepositoryAbstract
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
     * @return RepositoryAbstract
     */
    protected function sort($field, $sort): RepositoryAbstract
    {
        $this->model = $this->model->orderBy($field, $sort);
        return $this;
    }

    /**
     * Apply sort options.
     *
     * @param array $sort
     * @return RepositoryAbstract
     */
    protected function applySort($sort): RepositoryAbstract
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
     * @return Model
     */
    public function store(array $data): Model
    {
        $this->model = $this->model->create($data['data']['attributes']);
        return $this->model;
    }

    /**
     * Store item in database.
     *
     * @param array $data
     * @param Model $model
     * @return Model
     */
    public function update(array $data, $model): Model
    {
        $model->fill($data['data']['attributes'])->save();
        return $model;
    }

    /**
     * Delete item from database.
     *
     * @param Model $model
     * @return Model
     */
    public function destroy($model): Model
    {
        $model->delete();
        return $model;
    }
}
