<?php

use Illuminate\Database\Seeder;
use App\Sponsorship;
use App\Apartment;

class SponsorshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Sponsorship::class, 3)->create()->each(function($sponsorship){
        $apartments = Apartment::inRandomOrder() -> take(rand(1, 5)) -> get();
        $sponsorship -> apartments() -> attach($apartments);
      });
    }
}
