<?php

namespace Tests\Browser;

use App\Models\User;
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

            $browser->loginAs(User::find(1));

            // Can see builder
            $browser->visit('/builder')
                ->assertSee('Start a new Kill Team')
                ->assertDontSee('Sandbox Mode')
                ->assertPathIs('/builder');

            // Can go to next screen
            $browser->click('@new-kill-team')
                ->waitForText('Select a Game Mode')
                ->assertSee('Sandbox Mode')
                ->assertSee('Tournament Mode')
                ->assertPathIs('/builder')
                ->assertFragmentIs('/home/gamemode');

            // Can continue..
            $browser->click('@sandbox-mode')
                ->waitForText('Select a Faction')
                ->assertPathIs('/builder')
                ->assertFragmentIs('/sandbox/choosefaction');

            // All the factions are there.
            foreach (\Config::get('warhammer.factions') as $faction) {
                $browser->assertSee($faction);
            }

            // Can go back and select another mode
            $browser->click('@back')
                ->waitForText('Select a Game Mode')
                ->assertSee('Sandbox Mode')
                ->assertSee('Tournament Mode')
                ->assertPathIs('/builder')
                ->assertFragmentIs('/home/gamemode');

            // Can load a builder
            $browser->click('@tournament-mode')
                ->waitForText('Select a Faction')
                ->click('@Adeptus Astartes')
                ->waitForText('Command Roster')
                ->assertSee('Scout Sergeant')
                ->assertSee('Tactical Marine')
                ->assertFragmentIs('/tournament/1/ADEPTUS%20ASTARTES/builder');

            // Can pick a different faction instead
            $browser->click('@back')
                ->waitForText('Select a Faction')
                ->click('@Death Guard')
                ->waitForText('Command Roster')
                ->assertSee('Plague Champion')
                ->assertDontSee('Tactical Marine')
                ->assertFragmentIs('/tournament/7/DEATH%20GUARD/builder');
        });
    }

    public function testBasicFeatures()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/builder#/tournament/7/DEATH%20GUARD/builder')
                ->waitForText('Command Roster')
                ->assertFragmentIs('/tournament/7/DEATH%20GUARD/builder')
                ->assertElementsCountIs(0, '.vue-builder-fighter');

            // Can add Plague Marine
            $browser->click('@add Plague Marine')
                ->waitForText('Armed with')
                ->assertSeeIn('@fighters', 'Plague Marine')
                ->assertDontSeeIn('@fighters', 'Plague Marine Gunner')
                ->assertElementsCountIs(1, '.vue-builder-fighter');

            // Can add Plague Marine Gunner
            $browser->click('@add Plague Marine Gunner')
                ->waitForText('Armed with')
                ->assertSeeIn('@fighters', 'Plague Marine')
                ->assertSeeIn('@fighters', 'Plague Marine Gunner')
                ->assertElementsCountIs(2, '.vue-builder-fighter');

            // Can add a second Plague Marine and a second Gunner
            $browser->click('@add Plague Marine')
                ->click('@add Plague Marine Gunner')
                ->waitForText('Armed with')
                ->assertElementsCountIs(4, '.vue-builder-fighter');

            // Cannot add a third Gunner
            $browser->assertDisabled('@add Plague Marine Gunner')
                ->assertElementsCountIs(4, '.vue-builder-fighter');

            // Exit
            $browser->click('@back')->click('@back');
        });
    }

    public function testPointsCosts()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/builder#/tournament/7/DEATH%20GUARD/builder')
                ->assertFragmentIs('/tournament/7/DEATH%20GUARD/builder')
                ->waitForText('Poxwalker');

            // Can add Plague Marine Gunner
            $browser->click('@add Plague Marine Gunner')
                ->assertSeeIn('@points', 15)
                ->assertSeeIn('@fighters', 'Plague Marine Gunner')
                ->selectNthOption(0, '@select-wargear-option') // Plague Spewer
                ->assertSeeIn('@points', 19)
                ->selectNthOption(1, '@select-wargear-option') // Plague Belcher
                ->assertSeeIn('@points', 18);

            // Exit
            $browser->click('@back')->click('@back');
        });
    }

    public function testLimitations()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/builder#/tournament/1/ADEPTUS%20ASTARTES/builder')
                ->assertFragmentIs('/tournament/1/ADEPTUS%20ASTARTES/builder')
                ->waitForText('Reiver');

            $browser->click('@add Tactical Marine Gunner')
                ->click('@add Tactical Marine Gunner')
                ->assertElementsCountIs(2, '.vue-builder-fighter')
                ->assertSeeIn('.vue-builder-fighter:nth-child(1) .select-wargear-option', 'Flamer')
                ->selectNthOption(0, '.vue-builder-fighter:nth-child(1) .select-wargear-option')
                ->assertDisabled('.vue-builder-fighter:nth-child(1) .vue-partial-fighter-wargear-selector:nth-child(2) .select-wargear-option')
                ->assertDisabled('.vue-builder-fighter:nth-child(2) .vue-partial-fighter-wargear-selector:nth-child(1) .select-wargear-option')
                ->selectNthOption(1, '.vue-builder-fighter:nth-child(2) .vue-partial-fighter-wargear-selector:nth-child(2) .select-wargear-option')
                ->assertDisabled('.vue-builder-fighter:nth-child(1) .vue-partial-fighter-wargear-selector:nth-child(2) .select-wargear-option')
                ->assertSeeIn('@points', 16);

            // Exit
            $browser->click('@back')->click('@back');
        });
    }
}
