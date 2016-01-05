<?php

namespace Adrianyg7\Filterer;

use ReflectionMethod;

trait FiltererPaginationTrait
{
    /**
     * Paginate your results.
     *
     * @return void
     */
    protected function pagination()
    {

        if ( ! $this->paginate )
        {
            $this->results = $this->builder->get();
        }
        else
        {
            $this->paginator = $this->builder->paginate();
            $this->results = $this->paginator->getCollection();
        }
    }
}