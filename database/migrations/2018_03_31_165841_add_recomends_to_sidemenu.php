<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecomendsToSidemenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sidemenu', function (Blueprint $table) {

        });
        
        DB::table('sidemenu')->insert([
                ['parent_id'=>0,'codename'=>'MyRecomends','url'=>'/recomends','icon'=>'fa-camera-retro','order'=>25]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sidemenu', function (Blueprint $table) {

        });
        
        DB::table('sidemenu')
            ->where('codename', '=', 'MyRecomends')
            ->delete();
    }
}
