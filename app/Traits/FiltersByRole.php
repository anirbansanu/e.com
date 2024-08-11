<?php
// app/Traits/FiltersByRole.php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait FiltersByRole
{
    /**
     * Apply role-based filtering to a query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyRoleBasedFilter(Builder $query): Builder
    {
        // Example: filter based on a column like 'added_by' for 'vendor' role
        if (Auth::user()->hasRole('vendor')) {
            $query->where('added_by', Auth::id());
        }

        return $query;
    }

    /**
     * Find a model by its primary key with role-based filtering.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function find($id, $columns = ['*'])
    {
        $query = static::query()->select($columns);

        $query = (new static)->applyRoleBasedFilter($query);

        return $query->find($id);
    }

    /**
     * Get all models with role-based filtering.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function all($columns = ['*'])
    {
        $query = static::query()->select($columns);

        $query = (new static)->applyRoleBasedFilter($query);

        return $query->get();
    }

    /**
     * Get models by a specific condition with role-based filtering.
     *
     * @param array $conditions
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function where(array $conditions, $columns = ['*'])
    {
        $query = static::query()->select($columns);

        $query = (new static)->applyRoleBasedFilter($query);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->get();
    }

    /**
     * First model that matches the given condition with role-based filtering.
     *
     * @param array $conditions
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function whereFirst(array $conditions, $columns = ['*'])
    {
        $query = static::query()->select($columns);

        $query = (new static)->applyRoleBasedFilter($query);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->first();
    }

    /**
     * Paginate the results with role-based filtering.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function paginate(int $perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $query = static::query()->select($columns);

        $query = (new static)->applyRoleBasedFilter($query);

        return $query->paginate($perPage, $columns, $pageName, $page);
    }
}
