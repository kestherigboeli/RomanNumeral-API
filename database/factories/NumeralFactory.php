<?php

use Faker\Generator as Faker;

$factory->define(App\Numeral::class, function (Faker $faker) {
    return [
		'roman_numeral'				=> $faker->firstName,
		'number_requested'			=> $faker->numberBetween(1,5),
		'total_number_requested'	=> $faker->numberBetween(1,5)

    ];
});
