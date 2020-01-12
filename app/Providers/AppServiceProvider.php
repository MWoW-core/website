<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        foreach (UserRole::getKeys() as $role) {
            Blade::if($role, static function () use ($role) {
                return Auth::check()
                    && Auth::user()->role === UserRole::getValue($role);
            });
        }
    }
}
