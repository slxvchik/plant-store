<?php

namespace tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_successful_response()
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }
}
