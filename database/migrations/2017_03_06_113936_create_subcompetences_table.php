<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcompetences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competence_id')->unsigned()->index();
            $table->string('name',255)->default('');
            $table->timestamps();
            
            $table->foreign('competence_id')->references('id')->on('competences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcompetences');
    }
}
