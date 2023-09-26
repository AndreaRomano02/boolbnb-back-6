<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::pluck('id')->toArray();

        $apartments = config('apartments');
        foreach ($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->user_id = Arr::random($user_ids);
            $new_apartment->fill($apartment);
            $new_apartment->save();
        }
    }
}
