<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\DestroySessionPolicy;
use App\Models\User;

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

        Gate::define('isAdmin', function (User $user) {
            return $user->roles->contains('role_name', 'Admin');
        });

        Gate::define('isCustomer', function (User $user) {
            return $user->roles->contains('role_name', 'Customer');
        });

    }
}