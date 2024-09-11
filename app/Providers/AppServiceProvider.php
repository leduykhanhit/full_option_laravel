<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // dd(123);
//        Gate::define('viewPulse', function (User $user) {
//            dd($user);
//            echo 123123;
//            return true;
//            return $user->isAdmin();
//        });

        //
    }
}
