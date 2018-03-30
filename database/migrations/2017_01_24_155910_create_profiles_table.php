<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id')->unsigned()->index()->default(0);
            $table->string('name',255)->default('');
            $table->integer('grade')->unsigned()->default(0);
            $table->timestamps();
        });

        \DB::table('profiles')->insert([
            ['id'=>1,'flow_id'=>1,'name'=>'Разработчик','grade'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>2,'flow_id'=>1,'name'=>'Ведущий разработчик','grade'=>3,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>3,'flow_id'=>2,'name'=>'Консультант','grade'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['id'=>4,'flow_id'=>3,'name'=>'Ведущий тестировщик','grade'=>3,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
