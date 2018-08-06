<?php

use Illuminate\Database\Seeder;

class AdeptusMechanicusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keywords = ['IMPERIUM', 'SKITARII', 'INFANTRY', 'SKITARII RANGERS', 'SKITARII VANGUARD', 'SICARIAN RUSTSTALKER', 'SICARIAN INFILTRATOR'];
        foreach ($keywords as $name) {
            DB::table('keywords')->insert([
                'name' => $name,
            ]);
        }

        $datasheets = [
            'Skitarii Ranger' => [
                'minis' => [
                    'Skitarii Ranger', 'Ranger Gunner', 'Ranger Alpha',
                ],
                'keywords' => [1,2,3,4],
            ],
            'Skitarii Vanguard' => [
                'minis' => [
                    'Skitarii Vanguard', 'Vanguard Gunner', 'Vanguard Alpha',
                ],
                'keywords' => [1,2,3,5],
            ],
            'Sicarian Ruststalker' => [
                'minis' => [
                    'Sicarian Ruststalker', 'Ruststalker Princeps',
                ],
                'keywords' => [1,2,3,6],
            ],
            'Sicarian Infiltrator' => [
                'minis' => [
                    'Sicarian Infiltrator', 'Infiltrator Princeps',
                ],
                'keywords' => [1,2,3,7],
            ],
        ];

        $datasheet_id = 1;
        foreach ($datasheets as $d_name => $datasheet) {
            DB::table('datasheets')->insert([
                'name' => $d_name,
                'faction_id' => 4,
            ]);
            foreach ($datasheet['minis'] as $m_name) {
                DB::table('miniatures')->insert([
                    'name' => $m_name,
                    'datasheet_id' => $datasheet_id,
                ]);
            }
            foreach ($datasheet['keywords'] as $keyword_id) {
                DB::table('datasheet_keyword')->insert([
                    'datasheet_id' => $datasheet_id,
                    'keyword_id' => $keyword_id,
                ]);
            }
            $datasheet_id++;
        }
    }
}
