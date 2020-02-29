<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FoodType;
use Faker\Generator as Faker;

$factory->define(FoodType::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->unique()->word),
    ];
});
