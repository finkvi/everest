<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rp_user_id')->unsigned()->default(0);
            $table->integer('program_id')->unsigned()->index();
            $table->string('name',255);
            $table->timestamps();
        });

        DB::table('projects')->insert([
            ['id'=>1,'program_id'=>1,'name'=>'X5 Maxxing Лояльность','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>2,'program_id'=>1,'name'=>'X5 Maxxing Shutting Down','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>3,'program_id'=>2,'name'=>'ВТБ Кредиты','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
