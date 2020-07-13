<?php

namespace App\Http\ViewComposers;

use App\BlogPost;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-commented', 60, function () {
            return BlogPost::mostCommented()->take(3)->get();
        });

        $mostActive = Cache::tags(['blog-post'])->remember('users-most-active', 60, function () {
            return User::withMostBlogPosts()->take(3)->get();
        });

        $mostActiveLastMonth = Cache::tags(['blog-post'])->remember('users-most-active-last-month', 60, function () {
            return User::withMostBlogPostsLastMonth()->take(3)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);
    }
}
