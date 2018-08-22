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
                ->assertSee('Start a new Kill Team')
                ->assertDontSee('Sandbox Mode')
                ->assertPathIs('/builder')
                ;
            $browser->click('.vue-app .btn-primary')
                ->waitForText('Choose a Game Mode')
                ->assertSee('Sandbox Mode')
                ->assertPathIs('/builder')
                ->assertFragmentIs('/home/gamemode')
                ;

            $browser->click('.list-group:first-child .btn-primary')
                ->waitForText('Choose a Faction')
                ->assertPathIs('/builder')
                ->assertFragmentIs('/sandbox/choosefaction')
                ;

            foreach (\Config::get('warhammer.factions') as $faction) {
                $browser->assertSee($faction);
            }
        });
    }
}
