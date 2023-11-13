<?php

namespace Mri\ScoutPlus\Engines;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\MeilisearchEngine;
use Meilisearch\Client as MeilisearchClient;

class MeilisearchExtendedEngine extends MeilisearchEngine
{
    public function __construct(MeilisearchClient $meilisearch, $softDelete = false)
    {
        parent::__construct($meilisearch, $softDelete);
    }

    /**
     * Get the filter array for the query.
     *
     * @return string
     */
    protected function filters(Builder $builder)
    {
        $wheres = array_map(function ($value) {
            return ['operator' => '=', 'value' => $value];
        }, $builder->wheres);

        $filters = collect(array_merge($wheres, $builder->whereComparisons))->map(function ($value, $key) {
            if (is_bool($value)) {
                return sprintf('%s'.$value['operator'].'%s', $key, $value['value'] ? 'true' : 'false');
            }

            return is_numeric($value)
                ? sprintf('%s'.$value['operator'].'%s', $key, $value['value'])
                : sprintf('%s'.$value['operator'].'"%s"', $key, $value['value']);
        });

        if (property_exists($builder, 'whereBetween')) {
            foreach ($builder->whereBetween as $key => $values) {
                $filters->push(sprintf('%s "%s" TO "%s"', $key, $values[0], $values[1]));
            }
        }

        $whereInOperators = [
            'whereIns' => 'IN',
            'whereNotIns' => 'NOT IN',
        ];

        foreach ($whereInOperators as $property => $operator) {
            if (property_exists($builder, $property)) {
                foreach ($builder->{$property} as $key => $values) {
                    $filters->push(sprintf('%s %s [%s]', $key, $operator, collect($values)->map(function ($value) {
                        if (is_bool($value)) {
                            return sprintf('%s', $value ? 'true' : 'false');
                        }

                        return filter_var($value, FILTER_VALIDATE_INT) !== false
                            ? sprintf('%s', $value)
                            : sprintf('"%s"', $value);
                    })->values()->implode(', ')));
                }
            }
        }

        return $filters->values()->implode(' AND ');
    }
}
