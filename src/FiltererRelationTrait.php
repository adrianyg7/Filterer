<?php

namespace Adrianyg7\Filterer;

trait FiltererRelationTrait
{
    /**
     * Performs a relation where 'like' clause to Builder.
     *
     * @param  string      $relation
     * @param  string      $column
     * @param  string|null $input
     * @return 
     */
    public function relationLike($relation, $column, $input = null)
    {
        $input = $input ?: $column;

        if ($this->has($input))
        {
            $this->builder->whereHas($relation, function($query) use ($column, $input) {
                $query->where($column, 'like', "%{$this->input($input)}%");
            });
        }
    }
}