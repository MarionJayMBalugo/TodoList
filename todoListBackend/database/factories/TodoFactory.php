<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->randomDigit,
        'title'=>$faker->text(50),
        'body'=>$faker->text(250),
    ];
});
