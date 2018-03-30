<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->integer('tl_user_id')->unsigned()->default(0);
            $table->timestamps();
        });

        \DB::table('flow_project')->insert([
            ['flow_id'=>1,'project_id'=>1],
            ['flow_id'=>2,'project_id'=>1],
            ['flow_id'=>3,'project_id'=>1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flow_project');
    }
}
