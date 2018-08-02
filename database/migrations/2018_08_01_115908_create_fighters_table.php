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
            $table->unsignedInteger('killteam_id');
            $table->unsignedInteger('miniature_id');
            $table->unsignedInteger('specialism_id');
            $table->foreign('killteam_id')->references('id')->on('killteams');
            $table->foreign('miniature_id')->references('id')->on('miniatures');
            $table->foreign('specialism_id')->references('id')->on('specialisms');
            $table->string('name');
            $table->timestamps();
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
