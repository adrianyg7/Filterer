<?php

namespace Adrianyg7\Filterer;

trait FiltererModelTrait
{
    /**
     * Performs a where 'like' clause to Builder.
     *
     * @param  string      $column
     * @param  string|null $input
     * @return 
     */
    public function like($column, $input = null)
    {
        $input = $input ?: $column;

        if ($this->has($input))
        {
            $this->builder->where($column, 'like', "%{$this->input($input)}%");
        }
    }
}