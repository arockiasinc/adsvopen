<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_home_page_requires_basic_authentication(): void
    {
        $response = $this->get('/');

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
}
