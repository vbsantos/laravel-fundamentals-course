<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\BlogPost::all();

        if ($posts->count() === 0) {
            $this->command->info('There are no Blog Posts, so no Comments will be added.');
            return;
        }

        $commentsCount = (int) $this->command->ask('How many Comments would you like to add?', 100);

        factory(App\Comment::class, $commentsCount)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
