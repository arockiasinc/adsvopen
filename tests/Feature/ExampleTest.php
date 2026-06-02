<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['app.temporary_basic_auth' => true]);
    }

    public function test_the_home_page_requires_basic_authentication(): void
    {
        $response = $this
            ->withServerVariables([
                'PHP_AUTH_USER' => '',
                'PHP_AUTH_PW' => '',
                'HTTP_AUTHORIZATION' => '',
                'REDIRECT_HTTP_AUTHORIZATION' => '',
            ])
            ->withHeaders([
                'Authorization' => '',
            ])
            ->get('/');

        $response->assertStatus(401);
        $response->assertHeader('WWW-Authenticate', 'Basic realm="Adsvopen Demo"');
    }

    public function test_the_home_page_loads_with_valid_basic_authentication(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '.base64_encode('vopencom:LJ7ww~j$GTP#'),
        ])->get('/');

        $response->assertOk();
    }

    public function test_the_home_page_loads_when_live_server_redirects_basic_authentication_header(): void
    {
        $response = $this
            ->withServerVariables([
                'PHP_AUTH_USER' => '',
                'PHP_AUTH_PW' => '',
                'HTTP_AUTHORIZATION' => '',
                'REDIRECT_HTTP_AUTHORIZATION' => 'Basic '.base64_encode('vopencom:LJ7ww~j$GTP#'),
            ])
            ->get('/');

        $response->assertOk();
    }
}
