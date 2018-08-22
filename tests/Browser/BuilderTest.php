<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BuilderTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoadBuilder()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/builder')
                ->assertSee('Start a new Kill Team');
            $browser->click('.vue-app .btn-primary')
                ->assertSee('Choose a Game Mode');
        });
    }
}
