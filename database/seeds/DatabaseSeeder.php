<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'adam',
            'email' => 'adam@appsynergy.net',
            'password' => bcrypt('daboss'),
        ]);

        DB::table('users')->insert([
            'name' => 'gorka',
            'email' => 'gorka@killteams.com',
            'password' => bcrypt('daboss'),
        ]);

        DB::table('users')->insert([
            'name' => 'morka',
            'email' => 'morka@killteams.com',
            'password' => bcrypt('daboss'),
        ]);

        $specialisms = ['None', 'Leader', 'Combat', 'Comms', 'Demolitions', 'Heavy', 'Medic', 'Scout', 'Sniper', 'Veteran', 'Zealot'];
        foreach ($specialisms as $name) {
            DB::table('specialisms')->insert([
                'name' => $name,
            ]);
        }

        $factions = ['Adeptus Astartes', 'Grey Knights', 'Deathwatch', 'Adeptus Mechanicus', 'Astra Militarum', 'Heretic Astartes', 'Death Guard', 'Thousand Sons', 'Asuryani', 'Drukhari', 'Harlequins', 'Necrons', 'Orks', 'T\'au Empire', 'Tyranids', 'Genestealer Cults'];
        foreach ($factions as $name) {
            DB::table('factions')->insert([
                'name' => $name,
            ]);
        }

        $data = [
            'Adeptus Mechanicus' => [
                'Skitarii Ranger' => [
                    'minis' => [
                        'Skitarii Ranger', 'Ranger Gunner', 'Ranger Alpha',
                    ],
                ],
                'Skitarii Vanguard' => [
                    'minis' => [
                        'Skitarii Vanguard', 'Vanguard Gunner', 'Vanguard Alpha',
                    ],
                ],
                'Sicarian Ruststalker' => [
                    'minis' => [
                        'Sicarian Ruststalker', 'Ruststalker Princeps',
                    ],
                ],
                'Sicarian Infiltrator' => [
                    'minis' => [
                        'Sicarian Infiltrator', 'Infiltrator Princeps',
                    ],
                ],
            ],
        ];

        foreach ($data as $f_name => $datasheets) {
            $i = 0;
            foreach ($datasheets as $d_name => $datasheet) {
                DB::table('datasheets')->insert([
                    'name' => $d_name,
                    'faction_id' => array_search($f_name, $factions) + 1,
                ]);
                $i++;
                foreach ($datasheet['minis'] as $m_name) {
                    DB::table('miniatures')->insert([
                        'name' => $m_name,
                        'datasheet_id' => $i,
                    ]);
                }
            }
        }

        factory(App\Models\Ability::class, 5)->create();
        factory(App\Models\Keyword::class, 10)->create();
        //factory(App\Models\Datasheet::class, 10)->create();
        //factory(App\Models\Miniature::class, 10)->create();

        factory(App\Models\Killteam::class, 10)->create();
        factory(App\Models\Fighter::class, 10)->create();



    }
}
