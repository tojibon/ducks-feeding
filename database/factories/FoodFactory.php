<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Food;
use Faker\Generator as Faker;

$factory->define(Food::class, function (Faker $faker) {
    return [
        'food_type_id' => factory(App\FoodType::class)->create()->id,
        'name' => ucfirst($faker->word),
    ];
});
