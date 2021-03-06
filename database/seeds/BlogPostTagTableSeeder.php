<?php

use App\BlogPost;
use App\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if ($tagCount === 0) {
            $this->command->info('There are no Tags, so no Tags will be assigned.');
            return;
        }

        $howManyMin = min((int) $this->command->ask('Minimum tags on blog post:', 1), $tagCount);
        $howManyMax = min((int) $this->command->ask('Maximum tags on blog post:', $tagCount), $tagCount);

        BlogPost::all()->each(function (BlogPost $post) use ($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
