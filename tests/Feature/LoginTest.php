<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The login form can be displayed.
     *
     * @return void
     */
    public function testLoginFormDisplayed()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * A valid user can be logged in.
     *
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
        $response->assertLocation('/builder');
    }

    /**
     * An invalid user cannot be logged in.
     *
     * @return void
     */
    public function testDoesNotLoginAnInvalidUser()
    {
        $response = $this->get('/login');
        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
        $response->assertLocation('/login');
    }

    /**
     * A logged in user can be logged out.
     *
     * @return void
     */
    public function testLogoutAnAuthenticatedUser()
    {
        $response = $this->get('/login');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
        $response->assertLocation('/login');
    }
}
