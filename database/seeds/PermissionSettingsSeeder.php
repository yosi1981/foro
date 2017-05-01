<?php

use App\Core\PermissionSettings;
use Illuminate\Database\Seeder;

class PermissionSettingsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            [
                'id'          => 1,
                'name'        => 'Forum Settings',
                'is_category' => 1,
                'parent_id'   => 0,
                'order'       => 2,
            ],
            [
                'id'          => 2,
                'name'        => 'User Settings',
                'is_category' => 1,
                'parent_id'   => 0,
                'order'       => 1,
            ],

            [
                'id'          => 3,
                'is_category' => 1,
                'name'        => 'Moderation Settings',
                'parent_id'   => 0,
                'order'       => 3,
                'description' => '<span class="text-danger">Most moderation settings cannot be applied to admins.</span>'
            ],

            [
                'id'        => 4,
                'name'      => 'Threads Moderation',
                'parent_id' => 3,
                'order'     => 1,
            ],
            [
                'id'        => 5,
                'name'      => 'Posts Moderation',
                'parent_id' => 3,
                'order'     => 1,
            ],

            [
                'id'        => 6,
                'name'      => 'User Moderation',
                'parent_id' => 3,
                'order'     => 2,
            ],
            [
                'id'        => 7,
                'name'      => 'General Permissions',
                'parent_id' => 1,
                'order'     => 1,
            ],
            [
                'id'        => 8,
                'name'      => 'Thread Actions',
                'parent_id' => 1,
                'order'     => 3,
            ],
            [
                'id'        => 9,
                'name'      => 'Post Actions',
                'parent_id' => 1,
                'order'     => 2,
            ],
            [
                'id'        => 10,
                'name'      => 'Account Settings',
                'parent_id' => 2,
                'order'     => 1,
            ],
            [
                'id'        => 11,
                'name'      => 'General Settings',
                'parent_id' => 2,
                'order'     => 2,
            ],
        ];

        PermissionSettings::truncate();
        foreach ($settings as $setting) {
            PermissionSettings::firstOrCreate($setting);
        }
    }
}
