<?php

namespace Adrianyg7\Filterer;

use IteratorAggregate;
use Illuminate\Http\Request;
use Adrianyg7\Filterer\Contracts\BuildsWhenResolved;

abstract class Filterer implements BuildsWhenResolved, IteratorAggregate
{
    use FiltererModelTrait,
        FiltererPaginationTrait,
        FiltererRelationTrait,
        FiltererValidationTrait;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Model class to use.
     *
     * @var string
     */
    public $model;

    /**
     * Indicates if the Filterer should be paginated.
     *
     * @var boolean
     */
    public $paginate = true;

    /**
     * Total of results.
     *
     * @var integer
     */
    protected $total;

    /**
     * The Filterer Eloquent Query Builder
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * The Filterer Paginator.
     *
     * @var \Illuminate\Pagination\LengthAwarePaginator
     */
    protected $paginator;

    /**
     * The Filterer results.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $results;

    /**
     * Constructor
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Builds the given Filterer.
     *
     * @return mixed
     */
    public function build()
    {
        $this->validate();
        $this->init();
        $this->filters();
        $this->totalCount();
        $this->additionalColumns();
        $this->orderBys();
        $this->pagination();
    }

    /**
     * Initialize any data to be used over the Filterer,
     * eager load model relations, etc.
     *
     * @return void
     */
    public function init() {}

    /**
     * Apply the appropriate filters.
     *
     * @return void
     */
    public function filters() {}

    /**
     * Additional columns for your Builder, e.g. geo distance.
     *
     * @return void
     */
    public function additionalColumns() {}

    /**
     * Apply the corresponding order bys.
     *
     * @return void
     */
    public function orderBys() {}

    /**
     * Return the paginator.
     *
     * @return mixed
     */
    public function paginator()
    {
        return $this->paginator;
    }

    /**
     * Return the results.
     *
     * @return mixed
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * Eager loads the given relations.
     *
     * @param  array|string $relations
     * @return void
     */
    public function with($relations)
    {
        $this->builder->with($relations);
    }

    /**
     * Get the SQL representation of the Filterer query.
     *
     * @return string
     */
    public function toSql()
    {
        return $this->builder->toSql();
    }

    /**
     * Determine if the Filterer request contains a non-empty value for an input item.
     *
     * @param  string|array  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->request->has($key);
    }

    /**
     * Retrieve an input item from the Filterer request.
     *
     * @param  string  $key
     * @param  string|array|null  $default
     * @return string|array
     */
    public function input($key = null, $default = null)
    {
        return $this->request->input($key);
    }

    /**
     * Get an iterator for the results.
     *
     * @throws \Adrianyg7\Filterer\Exceptions\FiltererException
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->results->getIterator();
    }
}