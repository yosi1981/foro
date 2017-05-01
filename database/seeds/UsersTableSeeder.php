<?php

use App\User\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::first()) {
            $user = User::create([
                'username'     => 'admin',
                'email'        => 'admin@example.com',
                'activated'    => 1,
                'password'     => 'admin',
                'primary_role' => 1,
            ]);

            $user->roles()->attach(1);
        }

    }
}
