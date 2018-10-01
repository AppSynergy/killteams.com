<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipAbilitySpecialistselector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_specialistselector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ability_id');
            $table->unsignedInteger('specialistselector_id');
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->foreign('specialistselector_id')->references('id')->on('specialistselectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_specialistselector');
    }
}
