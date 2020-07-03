<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
         UsersSeeder::class,
         ServicesSeeder::class,
         ApartmentsSeeder::class,
         SponsorshipsSeeder::class,
         RequestsSeeder::class,
         ViewsSeeder::class
       ]);
    }
}
