<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apartment;
use Faker\Generator as Faker;

$factory->define(Apartment::class, function (Faker $faker) {
    return [

      "name" => $faker -> word(),
      "description" => $faker -> text(),
      "rooms" => $faker -> randomDigitNot(0),
      "beds" => $faker -> randomDigitNot(0),
      "bathrooms" => $faker -> randomDigitNot(0),
      "size" => $faker -> numberBetween($min = 20, $max = 100),
      "address" => $faker -> address(),
      "latitude" => $faker -> latitude($min = -90, $max = 90),
      "longitude" => $faker -> longitude($min = -180, $max = 180),
      "picture" => '/images/carduno.jpg',
      "show" => $faker -> boolean($chanceOfGettingTrue = 50)

    ];
  });
