<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Newsfetch extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'newsfetch';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Fetch news from external sources';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'newsfetch [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params = []): int
    {
        CLI::write('Running newsfetch command...', 'green');

        // TODO: implement fetching logic here.

        return EXIT_SUCCESS;
    }
}
