<?php

use Illuminate\Database\Seeder;

class SettingsGroupSeeder extends Seeder {

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
                'parent_id'   => 0,
                'is_category' => 1,
                'name'        => 'User Settings',
                'description' => 'Profile, Account and General settings for all users.',
                'order'       => 1,
                'icon' => 'fa fa-user'
            ],
            [
                'id'          => 2,
                'parent_id'   => 0,
                'is_category' => 1,
                'name'        => 'Forum Settings',
                'description' => 'These settings include settings for the forum, such as form validation, signature, report and rules.',
                'order'       => 2,
                'icon' => 'fa fa-comment'
            ],
            [
                'id'          => 3,
                'parent_id'   => 0,
                'is_category' => 1,
                'name'        => 'Site Settings',
                'description' => 'Site settings that apply to the entire website.',
                'order'       => 3,
                'icon' => 'fa fa-wrench'
            ],
            // User settings
            [
                'id'        => 4,
                'parent_id' => 1,
                'name'      => 'General',
                'order'     => 1,
            ],
            [
                'id'        => 5,
                'parent_id' => 1,
                'name'      => 'Form Validation',
                'description' => 'Please follow validation rules provided <a target="_blank" href="https://laravel.com/docs/5.3/validation#available-validation-rules">here</a>',
                'order'     => 2,
            ],
            // Forum Settings
            [
                'id'        => 6,
                'parent_id' => 2,
                'name'      => 'General',
                'order'     => 1,
            ],
            [
                'id'        => 7,
                'parent_id' => 2,
                'name'      => 'Form Validation',
                'description' => 'Please follow validation rules provided <a target="_blank" href="https://laravel.com/docs/5.3/validation#available-validation-rules">here</a>',
                'order'     => 2,
            ],
            [
                'id'        => 8,
                'parent_id' => 2,
                'name'      => 'Permissions',
                'order'     => 3,
            ],
            [
                'id'        => 9,
                'parent_id' => 2,
                'name'      => 'Icons',
                'order'     => 4,
            ],
            [
                'id'        => 14,
                'parent_id' => 2,
                'name'      => 'Report & Rules',
                'order'     => 4,
            ],
            [
                'id'        => 10,
                'parent_id' => 2,
                'name'      => 'Signature',
                'order'     => 5,
            ],

            // Site
            [
                'id'        => 11,
                'parent_id' => 3,
                'name'      => 'Registration',
                'order'     => 2,
            ],
            [
                'id'        => 12,
                'parent_id' => 3,
                'name'      => 'Login',
                'order'     => 3,
            ],

            [
                'id'        => 13,
                'parent_id' => 3,
                'name'      => 'General',
                'order'     => 1,
            ],

        ];

        foreach($settings as $setting) {
            try {
                \App\Core\SettingGroup::firstOrCreate(array_merge($setting, ['system_required' => 1]));
            } catch(\Exception $ex) {
                // Do Nothing
            }
        }
    }
}
