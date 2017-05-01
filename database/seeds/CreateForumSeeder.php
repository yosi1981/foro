<?php

use App\Forum\Forum;
use Illuminate\Database\Seeder;

class CreateForumSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUserTitles();

       $this->seedForums();
    }

    public function seedUserTitles()
    {
        $titles = [
            [
                'posts' => 0,
                'title' => 'Newbie',
                'stars' => 1,
            ],
            [
                'posts' => 5,
                'title' => 'Starter',
                'stars' => 2,
            ],
            [
                'posts' => 50,
                'title' => 'Member',
                'stars' => 3,
            ],
            [
                'posts' => 300,
                'title' => 'Respected Member',
                'stars' => 4,
            ],
            [
                'posts' => 1000,
                'title' => '1k Club Poster',
                'stars' => 5,
            ],
        ];

        foreach ($titles as $key => $title) {
            \App\Forum\UserTitle::firstOrCreate($title);
        }

    }

    public function seedForums()
    {
        Cache::forget('forums');

        $site = Forum::firstOrCreate([
            'name'        => 'Site and Support',
            'description' => 'Have questions or need support? Post here about your questions and give feedback about site.',
        ]);

        $feedback = $site->children()->firstOrCreate([
            'name'              => 'Feedback',
            'enable_rules'      => true,
            'rules_title'       => 'Please Read before posting!',
            'rules_description' => '1. Only request feedback here.
            2. If you have support questions please post that into the support forum
            3. Absolutely no spamming or you risk being banned!',
        ]);

        // Create a new thread
        $thread = $feedback->threads()->firstOrCreate([
            'title'         => 'My feedback.',
            'user_id'       => 1,
        ]);
        $post = $thread->posts()->firstOrCreate([
            'user_id' => 1,
            'message' => 'Hello. This is a sample feedback that I have. [b]Thank you.[/b]',
        ]);
        $thread->update(['first_post_id' => $post->id]);

        event(new \App\Events\Forum\ThreadWasCreated($thread));

        // Add more forums

        $support = $site->children()->firstOrCreate([
            'name'              => 'Support',
            'closed'            => true,
            'enable_rules'      => true,
            'rules_title'       => 'Important rules',
            'rules_description' => '1. No general support threads allowed. Only account and site support.
            2. Post your support thread to the appropriate forum. Creation of threads in this forum has been disabled.',
        ]);

        $feedback->children()->firstOrCreate(['name' => 'Request Features']);

        $support->children()->firstOrCreate(['name' => 'Site Support']);
        $support->children()->firstOrCreate(['name' => 'Account Support']);

        $lounge = Forum::firstOrCreate([
            'name'        => 'The Lounge',
            'description' => 'Discuss about anything here.',
        ]);

        $lounge->children()->firstOrCreate([
            'name'              => 'Personal Life',
            'enable_rules'      => true,
            'rules_title'       => 'Please Read',
            'rules_description' => '1. No spamming
            2. Do not share personal information such as names and numbers.',
        ]);


        $sports = $lounge->children()->firstOrCreate(['name' => 'Sports']);
        $sports->children()->firstOrCreate(['name' => 'Soccer']);
        $sports->children()->firstOrCreate(['name' => 'Basketball']);
    }
}
