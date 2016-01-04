<?php

namespace Adrianyg7\Filterer;

use Adrianyg7\Filterer\Exceptions\FiltererException;

trait FiltererModelTrait
{
    /**
     * Performs a where like clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function like($column, $input = null, $boolean = 'and')
    {
        $input = $input ?: $column;

        if ($this->requestHas($input)) {
            $this->builder->where($column, 'like', "%{$this->input($input)}%", $boolean);
        }

        return $this;
    }

    /**
     * Performs an equal where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function equal($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a not equal where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function notEqual($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '!=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a greater than where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function gt($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '>', $input, $boolean);

        return $this;
    }

    /**
     * Performs a greater than or equal where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function gte($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '>=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a less than where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function lt($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '<', $input, $boolean);

        return $this;
    }

    /**
     * Performs a less than or equal where clause to Builder.
     *
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this 
     */
    public function lte($column, $input = null, $boolean = 'and')
    {
        $this->applyWhere($column, '<=', $input, $boolean);

        return $this;
    }

    /**
     * Apply a where clause to builder.
     *
     * @param  string       $column
     * @param  string       $operator
     * @param  string|null  $input
     * @param  string       $boolean  
     * @return void
     */
    protected function applyWhere($column, $operator, $input, $boolean)
    {
        $input = $input ?: $column;

        if ($this->requestHas($input)) {
            $this->builder->where($column, $operator, $this->input($input), $boolean);
        }
    }
}