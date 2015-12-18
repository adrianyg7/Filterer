<?php

namespace spec\Adrianyg7\Filterer;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Illuminate\Http\Request;
use Adrianyg7\Filterer\Filterer;

class FiltererSpec extends ObjectBehavior
{
    function let(Request $request)
    {
        $this->beAnInstanceOf('spec\Adrianyg7\Filterer\FiltererStub');
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Adrianyg7\Filterer\FiltererStub');
    }

    function it_throws_exception_if_invalid_model_provided()
    {
        $this->model = 'Invalid';

        $this->shouldThrow('Adrianyg7\Filterer\Exceptions\FiltererException')->duringBuild();
    }
}

class FiltererStub extends Filterer {}