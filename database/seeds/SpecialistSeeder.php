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
        $specialisms = \Config::get('warhammer.specialisms');

        $abilities = [
            ['Resourceful', 1, null, 1],
            ['Bold', 2, 1, 1],
            ['Inspiring', 2, 1, 2],
            ['Paragon', 3, 2, 1],
            ['Tyrant', 3, 2, 1],
            ['Tactician', 3, 3, 1],
            ['Mentor', 3, 3, 1],
            ['Expert Fighter', 1, null, 2],
            ['Warrior Adept', 2, 8, 2],
            ['Deadly Counter', 2, 8, 2],
            ['Deathblow', 3, 9, 2],
            ['Combat Master', 3, 9, 2],
            ['Killer Instinct', 3, 10, 2],
            ['Bloodlust', 3, 10, 2],
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
