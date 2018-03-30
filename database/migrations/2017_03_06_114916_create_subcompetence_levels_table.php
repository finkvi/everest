<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcompetenceLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcompetence_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcompetence_id')->unsigned()->index()->default(0);
            $table->integer('level')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('subcompetence_id')->references('id')->on('subcompetences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcompetence_levels');
    }
}
