<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use App\Apartment;

use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    $apartments = Apartment::all();
    return [
      'transaction_id' => $faker -> swiftBicNumber(),
      'apartment_id' => rand(1, count($apartments))
    ];
});
