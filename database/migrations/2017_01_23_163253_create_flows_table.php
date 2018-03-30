<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flp_user_id')->unsigned()->default(0);
            $table->integer('business_unit_id')->unsigned();
            $table->string('name',255);
            $table->timestamps();
        });

        DB::table('flows')->insert([
            ['id'=>1,'business_unit_id'=>1,'name'=>'Разработка','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>2,'business_unit_id'=>1,'name'=>'Бизнес-анализ','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>3,'business_unit_id'=>1,'name'=>'Тестирование','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>4,'business_unit_id'=>1,'name'=>'Бизнес-интеграция','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>5,'business_unit_id'=>1,'name'=>'Управление','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flows');
    }
}
