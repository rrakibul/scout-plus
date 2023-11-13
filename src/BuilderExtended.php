<?php

namespace Mri\ScoutPlus;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Traits\Macroable;
use Laravel\Scout\Builder;
use Laravel\Scout\Contracts\PaginatesEloquentModels;
use Laravel\Scout\Contracts\PaginatesEloquentModelsUsingDatabase;

class BuilderExtended extends Builder
{
    /**
     * The "where" constraints added to the query.
     *
     * @var array
     */
    public $whereComparisons = [];

    /**
     * The "where" constraints added to the query.
     *
     * @var array
     */
    public $whereBetween = [];

    /**
     * Add a "TO" constraint to the search query.
     *
     * @param  string  $field
     * @param  array  $values
     * @return $this
     */
    public function whereBetween($field, array $values)
    {
        $this->whereBetween[$field] = $values;

        return $this;
    }

    /**
     * Add a constraint to the search query.
     *
     * @param  string  $field
     * @param  string  $operator
     * @param  mixed  $value
     * @return $this
     */
    public function where($field, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $this->wheres[$field] = $operator;
        } elseif (trim($operator) === '=') {
            $this->wheres[$field] = $value;
        } else {
            $this->whereComparisons[$field] = ['operator' => $operator, 'value' => $value];
        }

        return $this;
    }
}
