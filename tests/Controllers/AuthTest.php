<?php

use CodeIgniter\Test\CIUnitTestCase;

final class AuthTest extends CIUnitTestCase
{
    public function testChangePasswordRouteIsRegistered(): void
    {
        $routes = service('routes');

        $this->assertArrayHasKey('auth/change_password', $routes->getRoutes());
    }
}
