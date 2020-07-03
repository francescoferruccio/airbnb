<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sponsorship;
use Faker\Generator as Faker;

$factory->define(Sponsorship::class, function (Faker $faker) {
    return [
      'type' => rand(1, 3),
      'duration' => $faker -> randomElement($array = array (24,72,144)),
      'price' => $faker -> randomElement($array = array (2.99,5.99,9.99)),
      'transaction' => $faker -> swiftBicNumber()
    ];
});
