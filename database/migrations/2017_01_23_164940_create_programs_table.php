<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dp_user_id')->unsigned()->default(0);
            $table->integer('business_unit_id')->unsigned()->index();
            $table->string('name',255);
            $table->timestamps();
        });

        DB::table('programs')->insert([
            ['id'=>1,'business_unit_id'=>1,'name'=>'X5','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>2,'business_unit_id'=>1,'name'=>'ВТБ','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>3,'business_unit_id'=>1,'name'=>'Аэрофлот','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
