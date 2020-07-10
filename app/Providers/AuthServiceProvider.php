<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\BlogPost' => 'App\Policies\BlogPostPolicy'
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret', function ($user) {
            return $user->is_admin;
        });

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['delete'])) {
                return true;
            }
        });

        // Gate::resource('post', 'App\Policies\BlogPostPolicy');

        // Gate::define('post.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('post.delete', 'App\Policies\BlogPostPolicy@delete');


        // Gate::define('update-post', function ($user, $post) {
        //     // Verify if the user is able to update the post
        //     $authenticatedUser = $user->id;
        //     $postAuthor = $post->user->id;
        //     return $authenticatedUser == $postAuthor;
        // });

        // Gate::define('delete-post', function ($user, $post) {
        //     // Verify if the user is able to delete the post
        //     $authenticatedUser = $user->id;
        //     $postAuthor = $post->user->id;
        //     return $authenticatedUser == $postAuthor;
        // });

        // Gate::after(function ($user, $ability, $result) {
        //     if ($user->is_admin && in_array($ability, ['update-post'])) {
        //         return true;
        //     }
        // });

    }
}
