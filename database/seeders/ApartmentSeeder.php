<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use Faker\Generator;
use GuzzleHttp\Client;
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

        $apartments = config('apartments');
        foreach ($apartments as $apartment) {


            $address_info = str_replace(' ', '%20', $apartment['address']);
            $key = 'key=PWX9HGsOx1sGv84PlpxzgXIbaElOjVMF';
            $query = "https://api.tomtom.com/search/2/geocode/$address_info.json?storeResult=false&lat=37.337&lon=-121.89&view=Unified&$key";

            $client = new Client(['verify' => false]);
            $response = $client->get($query);
            $data = json_decode($response->getBody(), true);

            $new_apartment = new Apartment();
            $new_apartment->user_id = Arr::random($user_ids);
            $new_apartment->fill($apartment);
            $new_apartment->latitude = $data['results'][0]['position']['lat'];
            $new_apartment->longitude = $data['results'][0]['position']['lon'];

            $new_apartment->save();

            $apartments_services = [];
            foreach ($services_ids as $services_id) {
                if ($faker->boolean())  $apartments_services[] = $services_id;
            }

            $new_apartment->services()->attach($apartments_services);
        }
    }
}
