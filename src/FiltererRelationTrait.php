<?php

namespace Adrianyg7\Filterer;

trait FiltererRelationTrait
{
    /**
     * Performs a relation where like clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationLike($relation, $column, $input = null, $boolean = 'and')
    {
        $input = $input ?: $column;

        if ($this->requestHas($input)) {
            $this->builder->has($relation, '>=', 1, $boolean, function ($query) use ($column, $input) {
                $query->where($column, 'like', "%{$this->input($input)}%");
            });
        }

        return $this;
    }

    /**
     * Performs a relation where equal clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationEqual($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation where not equal clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationNotEqual($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '!=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation greater than where clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationGt($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '>', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation greater than or equal where clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationGte($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '>=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation less than where clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationLt($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '<', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation less than or equal where clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationLte($relation, $column, $input = null, $boolean = 'and')
    {
        $this->applyRelationWhere($relation, $column, '<=', $input, $boolean);

        return $this;
    }

    /**
     * Performs a relation where in clause to Builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string|null  $input
     * @param  string       $boolean
     * @return $this
     */
    public function relationIn($relation, $column, $input = null, $boolean = 'and')
    {
        $input = $input ?: $column;

        if ($this->requestHas($input)) {
            $this->builder->has($relation, '>=', 1, $boolean, function ($query) use ($column, $input) {
                $query->whereIn($column, $this->input($input));
            });
        }

        return $this;
    }

    /**
     * Apply a relation where clause to builder.
     *
     * @param  string       $relation
     * @param  string       $column
     * @param  string       $operator
     * @param  string|null  $input
     * @param  string       $boolean  
     * @return void
     */
    protected function applyRelationWhere($relation, $column, $operator, $input, $boolean)
    {
        $input = $input ?: $column;

        if ($this->requestHas($input)) {
            $this->builder->has($relation, '>=', 1, $boolean, function ($query) use ($column, $operator, $input) {
                $query->where($column, $operator, $this->input($input));
            });
        }
    }
}