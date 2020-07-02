<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\Apartment;
class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Payment::class, 60) -> make() -> each(function($payment){

        $apartment = Apartment::inRandomOrder() -> first();
        $payment -> apartment() -> associate($apartment);
        $payment -> save();
      });
    }
}
