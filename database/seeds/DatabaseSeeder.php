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

        factory(App\Models\Faction::class, 10)->create();
        factory(App\Models\Specialism::class, 10)->create();
        factory(App\Models\Fighter::class, 10)->create();
        factory(App\Models\Killteam::class, 10)->create();
        factory(App\Models\Miniature::class, 10)->create();

    }
}
