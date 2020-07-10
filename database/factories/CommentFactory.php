<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $created = $faker->dateTimeBetween('- 3 months');
    return [
        'content' => $faker->text,
        'created_at' => $created,
        'updated_at' => $created,
    ];
});
