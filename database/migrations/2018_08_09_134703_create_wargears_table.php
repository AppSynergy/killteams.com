<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWargearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wargears', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('faction_id');
            $table->unsignedInteger('points');
            $table->string('category');
            $table->timestamps();
            $table->foreign('faction_id')->references('id')->on('factions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wargears');
    }
}
