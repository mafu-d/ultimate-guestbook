<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->email,
        'age'     => $faker->numberBetween(18, 120),
        'comment' => implode("\n", $faker->paragraphs(2)),
    ];
});
