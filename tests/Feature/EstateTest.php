<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateTest extends TestCase
{
    public function test_get_estate()
    {
        $response = $this->get('/api/estate');
        $response->assertStatus(200);
    }
}
