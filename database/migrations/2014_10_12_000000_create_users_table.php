<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flow_id')->unsigned()->index()->default(0);
            $table->integer('current_profile_id')->unsigned()->index()->default(0);
            $table->integer('target_profile_id')->unsigned()->index()->default(0);
            $table->integer('mentor_user_id')->unsigned()->index()->default(0);
            $table->string('name',255);
            $table->string('rusname',255)->default('');
            $table->string('title',255)->default('');
            $table->string('department',255)->default('');
            $table->string('employeenumber',20)->default('');            
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->text('avatar')->nullable();
            $table->integer('admin')->unsigned()->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
