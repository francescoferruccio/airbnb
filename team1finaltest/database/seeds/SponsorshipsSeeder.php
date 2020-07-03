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
      $sponsorships = Sponsorship::all();
      foreach ($sponsorships as $sponsorship) {
        $apartments = Apartment::inRandomOrder() -> take(rand(1, 5)) -> get();
        $sponsorship -> apartments() -> attach($apartments);
      }
    }
}
