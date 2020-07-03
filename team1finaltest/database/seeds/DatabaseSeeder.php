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
      $services = [
        [
          'name' => 'wifi',
          'description' => 'Questo appartamento ha il wifi'
        ],
        [
          'name' => 'posto_macchina',
          'description' => 'Questo appartamento ha il posto macchina'
        ],
        [
          'name' => 'piscina',
          'description' => 'Questo appartamento ha la piscina'
        ],
        [
          'name' => 'portineria',
          'description' => 'Questo appartamento ha la portineria'
        ],
        [
          'name' => 'sauna',
          'description' => 'Questo appartamento ha la sauna'
        ],
        [
          'name' => 'vista_mare',
          'description' => 'Questo appartamento ha vista mare'
        ]
      ];

      foreach ($services as $service) {
        DB::table('services')->insert($service);
      }

      $sponsorships = [
        [
          'type' => 1,
          'duration' => 24,
          'price' => 2.99
        ],
        [
          'type' => 2,
          'duration' => 72,
          'price' => 5.99
        ],
        [
          'type' => 3,
          'duration' => 144,
          'price' => 9.99
        ]
        ];

        foreach ($sponsorships as $sponsorship) {
          DB::table('sponsorships')->insert($sponsorship);
        }


        $this->call([
         UsersSeeder::class,
         // ServicesSeeder::class,
         ApartmentsSeeder::class,
         // SponsorshipsSeeder::class,
         RequestsSeeder::class,
         ViewsSeeder::class
       ]);
    }

}
