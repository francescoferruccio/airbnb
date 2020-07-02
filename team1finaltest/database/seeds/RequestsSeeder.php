<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\Request;
class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Request::class, 60) -> make() -> each(function($request){

        $apartment = Apartment::inRandomOrder() -> first();
        $request -> apartment() -> associate($apartment);
        $request -> save();
      });
    }
}
