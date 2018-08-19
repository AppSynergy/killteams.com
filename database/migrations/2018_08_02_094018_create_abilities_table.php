<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('specialism_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('level')->default(0);
            $table->foreign('specialism_id')->references('id')->on('specialisms');
            $table->foreign('parent_id')->references('id')->on('abilities');
            $table->timestamps();
        });

        foreach (\Config::get('warhammer.specialism_abilities') as $ability) {
            DB::table('abilities')->insert([
                'name' => $ability[0],
                'level' => $ability[1],
                'parent_id' => $ability[2],
                'specialism_id' => $ability[3],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abilities');
    }
}
