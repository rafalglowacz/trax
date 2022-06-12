<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Cars\Models\Car;
use App\Modules\Trips\Models\Trip;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    return [
        'car_id' => factory(Car::class)->create()->id,
        'miles' => $faker->numberBetween(10, 100),
        'total' => function (array $attributes) {
            return $attributes['miles'];
        },
        'date' => $faker->dateTime,
    ];
});
