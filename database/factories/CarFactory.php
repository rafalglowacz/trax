<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Cars\Models\Car;
use App\User;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'make' => $faker->word,
        'model' => $faker->word,
        'year' => $faker->year,
    ];
});
