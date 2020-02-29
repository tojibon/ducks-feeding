<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feeding;
use Faker\Generator as Faker;

$factory->define(Feeding::class, function (Faker $faker) {

    $food = factory(App\Food::class)->create();

    return [
        'food_type_id' => $food->food_type_id,
        'food_id' => $food->id,
        'location_id' => factory(App\Location::class)->create()->id,
        'total_ducks' => $faker->numberBetween(10,200),
        'amount_foods' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 2, $max = 50),
        'feeding_time' => $faker->dateTime($max = 'now', $timezone = null),
        'daily_recurring' => $faker->boolean($chanceOfGettingTrue = 30),
    ];
});
