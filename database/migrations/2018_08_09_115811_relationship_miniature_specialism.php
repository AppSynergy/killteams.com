<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipMiniatureSpecialism extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miniature_specialism', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('miniature_id');
            $table->unsignedInteger('specialism_id');
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
        Schema::dropIfExists('miniature_specialism');
    }
}
