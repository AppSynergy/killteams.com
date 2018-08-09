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
            $table->string('name');
            foreach (\Config::get('warhammer.profiles') as $profile) {
                $table->tinyInteger($profile)->nullable();
            }
            $table->text('description')->nullable();
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
