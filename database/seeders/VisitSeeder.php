<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Visit;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $Faker): void
    {
        $apartments_ids = Apartment::pluck('id')->toArray();

        for ($i = 0; $i <= 50; $i++) {

            $rand_date =  $Faker->date() . ' ' . $Faker->time();
            $new_visit = new Visit();
            $new_visit->apartment_id = Arr::random($apartments_ids);
            $new_visit->IP_address = $Faker->ipv6();
            $new_visit->date = $rand_date;
            $new_visit->save();
        }
    }
}
