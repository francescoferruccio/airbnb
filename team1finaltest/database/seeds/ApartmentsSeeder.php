<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\User;
use App\Service;

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
        });
    }
}
