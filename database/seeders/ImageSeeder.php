<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        foreach ($apartment_ids as $n => $apartment_id) {
            $n++;
            $new_image = new Image();
            $new_image->apartment_id = $apartment_id;
            $new_image->path = "apartments_image/casa$n.jpg";
            $new_image->save();
        }
    }
}
