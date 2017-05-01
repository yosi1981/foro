<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin'     => 'Admin',
            'member'    => 'Member',
            'moderator' => 'Moderator',
            'banned'    => 'Banned',
        ];

        foreach ($roles as $name => $role) {
            \App\User\Role::firstOrCreate([
                'name'            => $name,
                'display_name'    => $role,
                'system_required' => true,
            ]);
        }

    }
}

