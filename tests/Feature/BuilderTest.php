<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuilderTest extends TestCase
{
    /**
     * You must be logged in to use the builder.
     *
     * @return void
     */
    public function testBuilderNotLoggedIn()
    {
        $response = $this->get('/builder');
        $response->assertStatus(302);
        $response->assertLocation('/login');
        $response->assertDontSee('<div id="app">');
    }

    /**
     * A valid user can use the builder.
     *
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = factory(User::class)->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $this->assertAuthenticatedAs($user);
        $response = $this->get('/builder');
        $response->assertOk();
        $response->assertSee('<div id="app">');
    }
}
