<?php

namespace Adrianyg7\Filterer\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class FiltererMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:filterer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filterer class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filterer';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('dummy:model', $this->option('model'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/filterer.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . $this->option('ns');
    }

    /**
     * Get the filterer command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The eloquent model that should be assigned.', 'App\User'],
            ['ns', null, InputOption::VALUE_OPTIONAL, 'The namespace that should be assigned.', '\Filterers'],
        ];
    }
}
