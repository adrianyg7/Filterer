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
     * The relations to eager load.
     *
     * @var array
     */
    public $with = [];

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
        $this->eagerLoad();
        $this->filters();
        $this->totalCount();
        $this->additionalColumns();
        $this->orderBys();
        $this->pagination();
    }

    /**
     * Eager loads the relations.
     *
     * @return void
     */
    protected function eagerLoad()
    {
        $this->builder->with($this->with);
    }

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
     * Get the SQL representation of the Filterer query.
     *
     * @return string
     */
    public function toSql()
    {
        return $this->builder->toSql();
    }

    /**
     * Determine if the Filterer request contains a non-empty value for the given key.
     *
     * @param  string|array  $key
     * @return bool
     */
    public function requestHas($key)
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

    /**
     * Handle dynamic method calls into the filterer model.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'orRelation'))
        {
            $method = camel_case(substr($method, 2));

            if ( count($parameters) == 2 ) {
                $parameters[] = $parameters[1];
            }

            $parameters[] = 'or';

            return call_user_func_array([$this, $method], $parameters);
        }
        else if (starts_with($method, 'or'))
        {
            $method = camel_case(substr($method, 2));

            if ( count($parameters) == 1 ) {
                $parameters[] = $parameters[0];
            }

            $parameters[] = 'or';

            return call_user_func_array([$this, $method], $parameters);
        }

        throw new FiltererException("Method [{$method}] does not exists");
    }
}