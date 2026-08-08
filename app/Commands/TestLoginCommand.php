<?php

namespace App\Commands;

use App\Libraries\IonAuth;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestLoginCommand extends BaseCommand
{
    protected $group       = 'CodeIgniter';
    protected $name        = 'auth:test-login';
    protected $description = 'Tests an IonAuth login against the configured database.';

    public function run(array $params = []): int
    {
        $identity = $params[0] ?? 'administrator';
        $password = $params[1] ?? 'password';

        CLI::write('Trying login for: ' . $identity);

        session()->start();
        $auth = new IonAuth();
        $result = $auth->login($identity, $password);

        if ($result) {
            CLI::write('LOGIN_OK', 'green');
            $user = $auth->user()->row();
            CLI::write('User: ' . ($user->username ?? 'n/a'));
            return EXIT_SUCCESS;
        }

        CLI::write('LOGIN_FAIL', 'red');
        foreach ($auth->errors() as $error) {
            CLI::write($error);
        }

        return EXIT_ERROR;
    }
}
