<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWargearselectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wargearselectors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fighter_id');
            $table->boolean('isSelected');
            $table->string('replace')->nullable();
            $table->string('option')->nullable();
            $table->timestamps();
            $table->foreign('fighter_id')->references('id')->on('fighters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wargearselectors');
    }
}
