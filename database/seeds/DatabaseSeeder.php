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

        $this->call([
            UserSeeder::class,
            SpecialistSeeder::class,
            FactionSeeder::class,
            //AdeptusMechanicusSeeder::class,
        ]);

        //factory(App\Models\Ability::class, 5)->create();
        //factory(App\Models\Keyword::class, 10)->create();
        //factory(App\Models\Datasheet::class, 10)->create();
        //factory(App\Models\Miniature::class, 10)->create();
        //factory(App\Models\Killteam::class, 10)->create();
        //factory(App\Models\Fighter::class, 10)->create();



    }
}
