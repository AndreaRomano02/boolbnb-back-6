<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartmet_ids = Apartment::pluck('id')->toArray();

        $message = new Message();
        $message->apartment_id = Arr::random($apartmet_ids);
        $message->name = 'Mario';
        $message->surname = 'Rossi';
        $message->email = 'mariorossi@gmail.com';
        $message->content = 'Ciao sarei interessato all\'appartamento ci possiamo sentire?';
        $message->save();
    }
}
