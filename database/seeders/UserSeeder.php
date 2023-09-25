<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // admins data import
        $users = config('admins_data');

        // seeding Users table
        foreach ($users as $user) {
            $new_user = new User();
            $new_user->fill($user);
            $new_user->save();
        }
    }
}
