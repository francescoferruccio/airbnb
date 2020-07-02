<?php

use Illuminate\Database\Seeder;
use App\Service;
class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Service::class, 6) -> create();

    }

};
