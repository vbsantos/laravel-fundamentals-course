<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        if ($users->count() === 0) {
            $this->command->info('There are no Users, so no Blog Posts will be added.');
            return;
        }

        $postsCount = (int) $this->command->ask('How many Blog Posts would you like to add?', 20);

        factory(App\BlogPost::class, $postsCount)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
