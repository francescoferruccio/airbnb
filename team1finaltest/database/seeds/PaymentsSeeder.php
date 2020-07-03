<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\Sponsorship;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Payment::class, 20) -> make() -> each(function($payment){
          $sponsorship = Sponsorship::inRandomOrder() -> first();
          $payment -> sponsorship() -> associate($sponsorship);
          $payment -> save();
      });
    }
  }
