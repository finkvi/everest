<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileCompetenceLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_competence_level', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->default(0);
            $table->integer('competence_id')->unsigned()->index()->default(0);
            $table->integer('level')->unsigned()->index()->default(0);
            $table->timestamps();
        });

        \DB::table('profile_competence_level')->insert([
            ['profile_id'=>1,'competence_id'=>1,'level'=>2],
            ['profile_id'=>1,'competence_id'=>2,'level'=>0],
            ['profile_id'=>1,'competence_id'=>4,'level'=>0],

            ['profile_id'=>2,'competence_id'=>1,'level'=>3],
            ['profile_id'=>2,'competence_id'=>2,'level'=>2],
            ['profile_id'=>2,'competence_id'=>4,'level'=>0],

            ['profile_id'=>3,'competence_id'=>3,'level'=>2],
            ['profile_id'=>3,'competence_id'=>4,'level'=>1],

            ['profile_id'=>4,'competence_id'=>4,'level'=>2],
            ['profile_id'=>4,'competence_id'=>5,'level'=>3],
            ['profile_id'=>4,'competence_id'=>6,'level'=>3],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_competence_level');
    }
}
