<?php

use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialisms = [
            'None', 'Leader', 'Combat', 'Comms', 'Demolitions',
            'Heavy', 'Medic', 'Scout', 'Sniper', 'Veteran', 'Zealot'
        ];

        $abilities = [
            ['Resourceful', 1, null, 2],
            ['Bold', 2, 1, 2],
            ['Inspiring', 2, 1, 2],
            ['Paragon', 3, 2, 2],
            ['Tyrant', 3, 2, 2],
            ['Tactician', 3, 3, 2],
            ['Mentor', 3, 3, 2],
            ['Expert Fighter', 1, null, 3],
            ['Warrior Adept', 2, 8, 3],
            ['Deadly Counter', 2, 8, 3],
            ['Deathblow', 3, 9, 3],
            ['Combat Master', 3, 9, 3],
            ['Killer Instinct', 3, 10, 3],
            ['Bloodlust', 3, 10, 3],
        ];

        foreach ($specialisms as $name) {
            DB::table('specialisms')->insert([
                'name' => $name,
            ]);
        }

        foreach ($abilities as $ability) {
            DB::table('abilities')->insert([
                'name' => $ability[0],
                'level' => $ability[1],
                'parent_id' => $ability[2],
                'specialism_id' => $ability[3],
            ]);
        }
    }
}
