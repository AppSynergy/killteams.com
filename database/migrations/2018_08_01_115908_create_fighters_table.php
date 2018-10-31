<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fighters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('killteam_id');
            $table->unsignedInteger('faction_id');
            $table->unsignedInteger('miniature_id');
            $table->unsignedInteger('specialism_id')->nullable();
            $table->timestamps();
            $table->foreign('killteam_id')->references('id')->on('killteams')->onDelete('cascade');
            $table->foreign('faction_id')->references('id')->on('factions');
            $table->foreign('miniature_id')->references('id')->on('miniatures');
            $table->foreign('specialism_id')->references('id')->on('specialisms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('fighters');
    }
}
