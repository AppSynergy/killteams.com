<?php

use Illuminate\Database\Seeder;

class FactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $factions = ['Adeptus Astartes', 'Grey Knights', 'Deathwatch', 'Adeptus Mechanicus', 'Astra Militarum', 'Heretic Astartes', 'Death Guard', 'Thousand Sons', 'Asuryani', 'Drukhari', 'Harlequins', 'Necrons', 'Orks', 'T\'au Empire', 'Tyranids', 'Genestealer Cults'];
        foreach ($factions as $name) {
            DB::table('factions')->insert([
                'name' => $name,
            ]);
        }
    }
}
