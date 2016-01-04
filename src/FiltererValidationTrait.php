<?php

namespace Adrianyg7\Filterer;

use Illuminate\Database\Eloquent\Model;
use Adrianyg7\Filterer\Exceptions\FiltererException;

trait FiltererValidationTrait
{
    /**
     * Validates that the current Filterer can be used.
     *
     * @throws \Adrianyg7\Filterer\Exceptions\FiltererException
     * @return void
     */
    protected function validate()
    {
        if ( ! $this->model or ! class_exists($this->model) ) {
            throw new FiltererException('Please set the $model property to your model path.');
        }

        if ( ! $this->isEloquentModel() ) {
            throw new FiltererException('$model property is not an instance of Illuminate\Database\Eloquent\Model');
        }
    }

    /**
     * Checks if set $model property is an instance of Eloquent Model.
     *
     * @return boolean
     */
    protected function isEloquentModel()
    {
        $instance = new $this->model;

        if ( ! $instance instanceof Model ) return false;

        $this->builder = $instance->newQuery();

        return true;
    }
}