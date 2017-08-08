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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Post::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->sentence,
        'body' => $faker->realText(2000),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Comment::class, function (Faker\Generator $faker) {

    return [
        'body' => $faker->realText(300),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(Post::class)->create()->id;
        }
    ];
});
