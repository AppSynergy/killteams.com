<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipAbilityDatasheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_datasheet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ability_id');
            $table->unsignedInteger('datasheet_id');
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->foreign('datasheet_id')->references('id')->on('datasheets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_datasheet');
    }
}
