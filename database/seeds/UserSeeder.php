<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'adam',
            'email' => 'waaaaagh@killteams.com',
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
    }
}
