<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
      "status" => $faker ->  randomElement($array = array ('accepted','refused')),
      "price" => $faker -> randomElement($array = array (2.99,5.99,9.99)),
      "type" => $faker ->   randomElement($array = array (1,2,3)),
      "active" => $faker -> boolean($chanceOfGettingTrue = 50)
    ];
});
