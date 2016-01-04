<?php

namespace Adrianyg7\Filterer;

use ReflectionMethod;
use Illuminate\Pagination\LengthAwarePaginator;

trait FiltererPaginationTrait
{
    /**
     * Sets the total count of your results in case you are
     * adding additional columns.
     *
     * @return void
     */
    protected function totalCount()
    {
        if ($this->hasAdditionalColumns() and $this->paginate) {
            $this->total = $this->builder->count();
        }
    }

    /**
     * Determines if child class is using additional columns.
     *
     * @return boolean
     */
    protected function hasAdditionalColumns()
    {
        $reflectorMethod = new ReflectionMethod(get_called_class(), 'additionalColumns');

        return $reflectorMethod->getDeclaringClass()->getName() !== get_class();
    }

    /**
     * Paginate your results.
     * If you added additional columns, you can use
     * this class's paginate method.
     *
     * @return void
     */
    protected function pagination()
    {

        if ( ! $this->paginate )
        {
            $this->results = $this->builder->get();
        }
        else if ($this->hasAdditionalColumns())
        {
            $this->paginate();
        }
        else
        {
            $this->paginator = $this->builder->paginate();
            $this->results = $this->paginator->getCollection();
        }
    }

    /**
     * Paginates Filterer using LengthAwarePaginator.
     * Specially useful when you add custom columns, causing the
     * Query Builder's paginate method to mess.
     *
     * @return void
     */
    protected function paginate($perPage = null)
    {
        $page = $this->request->input('page', 1);
        $perPage = $perPage ?: $this->builder->getModel()->getPerPage();
        $data = $this->builder->skip( $perPage * ($page - 1) )->take($perPage)->get();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $options = ['path' => LengthAwarePaginator::resolveCurrentPath()];

        $this->paginator = new LengthAwarePaginator($data, $this->total, $perPage, $currentPage, $options);
        $this->results = $this->paginator->getCollection();
    }
}