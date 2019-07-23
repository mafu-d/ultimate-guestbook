<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->email,
        'comment' => implode("\n", $faker->paragraphs(2)),
    ];
});
