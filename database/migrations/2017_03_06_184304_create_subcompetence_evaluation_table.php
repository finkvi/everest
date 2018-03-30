<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcompetenceEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcompetence_evaluation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned()->index();
            $table->integer('subcompetence_id')->unsigned()->index();
            $table->smallInteger('value')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcompetence_evaluation');
    }
}
