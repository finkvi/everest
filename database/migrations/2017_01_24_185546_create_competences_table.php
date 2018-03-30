<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->default('');
            $table->timestamps();
        });

        \DB::table('competences')->insert([
            ['id'=>1,'name'=>'Проектирование'],
            ['id'=>2,'name'=>'Архитектура'],
            ['id'=>3,'name'=>'Выявление требований'],
            ['id'=>4,'name'=>'Лидерство'],
            ['id'=>5,'name'=>'Функциональное тестирование'],
            ['id'=>6,'name'=>'Автоматизация тестирования']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competences');
    }
}
