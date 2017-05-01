<?php

use Illuminate\Database\Seeder;

class CoreSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logs = [
            [
                'name'  => 'mod_note',
                'value' => '',
                'type'  => 'notes',
            ],
            [
                'name'  => 'admin_note',
                'value' => '',
                'type'  => 'notes',
            ],
            [
                'name'  => 'total_users',
                'value' => 0,
                'type'  => 'stats',
            ],
            [
                'name'  => 'total_threads',
                'value' => 0,
                'type'  => 'stats',
            ],
            [
                'name'  => 'total_posts',
                'value' => 0,
                'type'  => 'stats',
            ],
        ];

        foreach ($logs as $log) {
            try {
                $core = \App\Core\Core::where('name', $log['name'])->first();
                if (!$core) {
                    \App\Core\Core::create($log);
                }
            } catch (\Exception $ex) {
                // Do Nothing
            }
        }
    }
}
