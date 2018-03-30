<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
    	'login' => $faker->username,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'employeenumber' => $faker->randomNumber,
        'title' => $faker->jobTitle,
        'department' => $faker->state,
        'avatar' => (string)Image::make($faker->imageUrl(96,96,'people'))->encode('jpg', 85)->encode('data-url')
    ];                    
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {

    return [
        'body' => $faker->realText($maxNbChars = 300, $indexSize = 2),
        'created_at' => $faker->dateTimeThisMonth,
        'updated_at' => $faker->dateTimeThisMonth
    ];                    
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {

	$u = DB::table('users')->inRandomOrder()->first();

    return [
    	'user_id' => $u->id,
        'body' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'created_at' => $faker->dateTimeThisMonth,
        'updated_at' => $faker->dateTimeThisMonth
    ];                    
});
