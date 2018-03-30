<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidemenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidemenu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->default(0);
            $table->string('codename',255)->default('');
            $table->string('url',255)->default('');
            $table->string('redirect',255)->default('');
            $table->string('icon',255)->default('');
            $table->integer('order')->unsigned()->index()->default(0);
            $table->timestamps();
        });

        DB::table('sidemenu')->insert([
            ['id'=>1,'parent_id'=>0,'codename'=>'Profile','url'=>'/profile','icon'=>'fa-user','order'=>10],
            ['id'=>2,'parent_id'=>0,'codename'=>'MyEmployees','url'=>'/myemployees','icon'=>'fa-users','order'=>20],
            ['id'=>3,'parent_id'=>0,'codename'=>'Administration','url'=>'/admin','icon'=>'fa-cog','order'=>30],
            ['id'=>4,'parent_id'=>0,'codename'=>'Support','url'=>'/support','icon'=>'fa-comments-o','order'=>40],

            ['id'=>0,'parent_id'=>3,'codename'=>'BusinessUnit','url'=>'/admin/bu','icon'=>'','order'=>10],
            ['id'=>0,'parent_id'=>3,'codename'=>'Flows','url'=>'/admin/flows','icon'=>'','order'=>20],
            ['id'=>0,'parent_id'=>3,'codename'=>'Programs','url'=>'/admin/programs','icon'=>'','order'=>30],
            ['id'=>0,'parent_id'=>3,'codename'=>'Projects','url'=>'/admin/projects','icon'=>'','order'=>40],
            ['id'=>0,'parent_id'=>3,'codename'=>'People','url'=>'/admin/users','icon'=>'','order'=>50],            
            ['id'=>0,'parent_id'=>3,'codename'=>'Competences','url'=>'/admin/competences','icon'=>'','order'=>60],
            ['id'=>0,'parent_id'=>3,'codename'=>'Profiles','url'=>'/admin/profiles','icon'=>'','order'=>70],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidemenu');
    }
}
