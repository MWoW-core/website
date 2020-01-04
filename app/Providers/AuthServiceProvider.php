<?php

namespace App\Providers;

use App\Account;
use App\Comment;
use App\Enums\UserRole;
use App\News;
use App\Policies\AccountPolicy;
use App\Policies\CommentPolicy;
use App\Policies\NewsPolicy;
use App\Policies\RealmPolicy;
use App\Policies\ServerPolicy;
use App\Policies\TaskPolicy;
use App\Realm;
use App\Server;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Server::class => ServerPolicy::class,
        Task::class => TaskPolicy::class,
        Realm::class => RealmPolicy::class,
        News::class => NewsPolicy::class,
        Account::class => AccountPolicy::class,
        Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(fn (User $user) => $user->role->is(UserRole::Admin));
    }
}
