<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // Unguard mass assignment exceptions
        Eloquent::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(SettingsGroupSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(UsersTableSeeder::class); //not this in rebuild db
        $this->call(CreateForumSeeder::class); //not this in rebuild db
        $this->call(CoreSeeder::class);
        $this->call(PermissionSettingsSeeder::class);
        $this->call(PagesTableSeeder::class);

        //Reguard
        Eloquent::reguard();
    }
}
