<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $user_ids = User::pluck('id')->toArray();
        $services_ids = Service::pluck('id')->toArray();
        $sponsors_ids = Sponsor::pluck('id')->toArray();

        $apartments = config('apartments');
        foreach ($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->user_id = Arr::random($user_ids);
            $new_apartment->fill($apartment);
            $new_apartment->save();

            $apartments_services = [];
            foreach ($services_ids as $services_id) {
                if ($faker->boolean())  $apartments_services[] = $services_id;
            }

            $new_apartment->services()->attach($apartments_services);

            $apartments_sponsor = Arr::random($sponsors_ids);

            $new_apartment->sponsors()->attach($apartments_sponsor);
        }
    }
}
