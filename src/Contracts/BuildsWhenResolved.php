<?php

namespace Adrianyg7\Filterer\Contracts;

interface BuildsWhenResolved
{
    /**
     * Builds the given class instance.
     *
     * @return void
     */
    public function build();
}