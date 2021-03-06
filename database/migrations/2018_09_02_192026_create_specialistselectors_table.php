<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialistselectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialistselectors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fighter_id');
            $table->unsignedInteger('specialism_id')->nullable();
            $table->unsignedInteger('level');
            $table->timestamps();
            $table->foreign('fighter_id')->references('id')->on('fighters')->onDelete('cascade');
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
        Schema::dropIfExists('specialistselectors');
    }
}
