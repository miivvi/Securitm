<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractEloquentRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * AbstractRepository constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->model = app($this->modelClass());
        $this->request = $request;
    }

    /**
     * @param array $decorators
     * @return Builder
     */
    public function query(array $decorators = []): Builder
    {
        $query = $this->model::query();

        if (!empty($decorators) && $this->request->has('sort')) {
            $fields = [
                'sort' => $this->request->get('sort'),
            ];
            $this->decorate($query, $fields);
        }
        return $query;
    }

    /**
     * @param $id
     * @param Builder|null $query
     * @return Model|null
     */
    public function get($id, ?Builder $query = null): ?Model
    {
        return ($query ?: $this->query())->findOrFail($id);
    }

    /**
     * @param $builder
     * @param $decorators
     * @return void
     */
    private function decorate($builder, $decorators): void
    {
        foreach ($decorators as $option) {
            [$field, $direction] = $this->parseSortOption($option);
            $builder->orderBy($field, $direction);
        }
    }

    /**
     * @param string $option
     * @return array
     */
    private function parseSortOption(string $option): array
    {
        $direction = 'asc';
        if (str_starts_with($option, '-')) {
            $option = substr($option, 1);
            $direction = 'desc';
        }

        return [$option, $direction];
    }

    abstract protected function modelClass(): string;
}
