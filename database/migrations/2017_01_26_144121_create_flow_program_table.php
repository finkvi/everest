<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_program', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id')->unsigned()->index();
            $table->integer('program_id')->unsigned()->index();
            $table->integer('pl_user_id')->unsigned()->default(0);
            $table->timestamps();
        });

        \DB::table('flow_program')->insert([
            ['flow_id'=>1,'program_id'=>1],
            ['flow_id'=>2,'program_id'=>1],
            ['flow_id'=>3,'program_id'=>1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flow_program');
    }
}
