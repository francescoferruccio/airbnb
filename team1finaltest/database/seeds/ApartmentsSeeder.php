<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\User;
use App\Service;
use App\Sponsorship;

class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Apartment::class, 40) -> make() -> each(function($apartment){

          $user = User::inRandomOrder() -> first();
          $apartment -> user() -> associate($user);
          $apartment -> save();
          $services = Service::inRandomOrder()-> take(rand(1,6)) -> get();
          $apartment -> services() -> attach($services);

          $sponsored = rand(0, 1);

          if($sponsored) {
            $sponsorship = Sponsorship::inRandomOrder() -> first();
            $apartment -> sponsorships() -> attach($sponsorship, [
              'transaction_id' => Str::random(12),
              'end_sponsorship' => now()->addHours($sponsorship->duration)
            ]);
          }
        });
    }
}
