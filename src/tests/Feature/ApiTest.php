<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_web_is_disabled(): void
    {
        $response = $this->get('/');
        $response->assertStatus(404);
    }
}
