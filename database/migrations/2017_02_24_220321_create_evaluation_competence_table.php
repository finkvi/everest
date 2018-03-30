<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationCompetenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_evaluation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned()->index();
            $table->integer('competence_id')->unsigned()->index();
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
        Schema::dropIfExists('competence_evaluation');
    }
}
