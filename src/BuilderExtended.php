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

    
}
