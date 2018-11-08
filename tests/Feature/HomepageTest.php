<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomepage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
