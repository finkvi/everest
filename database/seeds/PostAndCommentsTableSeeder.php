<?php

use Illuminate\Database\Seeder;

class PostAndCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \DB::table('users')->inRandomOrder()->limit(10)->get();

        foreach ($users as $u)
        {
        	$u = App\User::find($u->id);
        	$u->posts()->save(factory(App\Post::class)->make());
        }

		$posts = App\Post::get();

        foreach ($posts as $p)
        {
        	$lim = rand(3,6);

        	for($i=0; $i<=$lim; $i++)
        	{
        		$p->comments()->save(factory(App\Comment::class)->make());
        	}
        }

    }
}
