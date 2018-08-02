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

        foreach (['None', 'Leader', 'Combat', 'Comms', 'Demolitions', 'Heavy', 'Medic', 'Scout', 'Sniper', 'Veteran', 'Zealot'] as $name) {
            DB::table('specialisms')->insert([
                'name' => $name,
            ]);
        }

        foreach (['Adeptus Astartes', 'Grey Knights', 'Deathwatch', 'Adeptus Mechanicus', 'Astra Militarum', 'Heretic Astartes', 'Death Guard', 'Thousand Sons', 'Asuryani', 'Drukhari', 'Harlequins', 'Necrons', 'Orks', 'T\'au Empire', 'Tyranids', 'Genestealer Cults'] as $name) {
            DB::table('factions')->insert([
                'name' => $name,
            ]);
        }

        factory(App\Models\Ability::class, 5)->create();
        factory(App\Models\Keyword::class, 10)->create();
        factory(App\Models\Datasheet::class, 10)->create();
        factory(App\Models\Miniature::class, 10)->create();

        factory(App\Models\Killteam::class, 10)->create();
        factory(App\Models\Fighter::class, 10)->create();



    }
}
