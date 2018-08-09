<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miniatures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('datasheet_id');
            // Model Name
            $table->string('name');
            // Profiles
            foreach (\Config::get('warhammer.profiles') as $profile) {
                $table->tinyInteger($profile)->nullable();
            }
            // Description
            $table->text('description')->nullable();
            // Wargear Options
            // Abilities
            // Specialists
            $table->string('specialists');
            $table->timestamps();
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
        Schema::dropIfExists('miniatures');
    }
}
