<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $page = [
            'title'           => 'Terms and Conditions',
            'slug'            => 'terms',
            'body'            => $faker->paragraphs(50, true),
            'system_required' => true,
        ];

        \App\Page::firstOrCreate($page);
    }
}
