<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $encodedCredentials = base64_encode('vopencom:LJ7ww~j$GTP#');

        $this->withServerVariables([
            'PHP_AUTH_USER' => 'vopencom',
            'PHP_AUTH_PW' => 'LJ7ww~j$GTP#',
            'HTTP_AUTHORIZATION' => "Basic {$encodedCredentials}",
        ]);
    }
}
