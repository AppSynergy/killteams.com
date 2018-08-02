<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipDatasheetKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasheet_keyword', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('datasheet_id');
            $table->unsignedInteger('keyword_id');
            $table->foreign('datasheet_id')->references('id')->on('datasheets');
            $table->foreign('keyword_id')->references('id')->on('keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datasheet_keyword');
    }
}
