<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\User;
use App\Policies\AuthUserPolicy;
use App\Policies\AuthEmployeePolicy;
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
        Gate::policy(Employee::class, AuthEmployeePolicy::class);

        Gate::policy(User::class, AuthUserPolicy::class);
    }
}
