<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @link    : www.octopy.xyz
 * @license : MIT
 */

namespace Octopy\Console\Command;

use Exception;
use Octopy\Console\Argv;
use Octopy\Console\Output;
use Octopy\Console\Command;

class MakeControllerCommand extends Command
{
    /**
     * @var string
     */
    protected $command = 'make:controller';

    /**
     * @var array
     */
    protected $options = [
        '--resource' => 'Generate a resource controller class.',
    ];

    /**
     * @var array
     */
    protected $argument = [
        'name' => 'The name of the class',
    ];

    /**
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * @param  Argv   $argv
     * @param  Output $output
     * @return string
     */
    public function handle(Argv $argv, Output $output)
    {
        try {
            $parsed = $this->parse($argv);
        } catch (Exception $exception) {
            return $output->error('Not enough arguments (missing : "name").');
        }

        if (file_exists($location = $this->app['path']->app->HTTP->controller($parsed['location']))) {
            return $output->warning('Controller already exists.');
        }

        $data = [
            'DummyNameSpace' => $parsed['namespace'],
            'DummyClassName' => $parsed['classname'],
        ];

        $template = 'Controller.plain';
        if ($argv->get('--resource')) {
            $template = 'Controller.resource';
        }

        if ($this->generate($location, $template, $data)) {
            return $output->success('Controller created successfully.');
        }
    }
}
