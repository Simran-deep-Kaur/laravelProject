<?php

namespace App\Providers;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;
use App\Listeners\GenerateActiveTimeDuration;
use App\Listeners\GenerateLoginTime;
use App\Listeners\GenerateLoginTimeRegistered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Logout::class => [
            GenerateActiveTimeDuration::class
        ],
        Registered::class => [
            GenerateLoginTimeRegistered::class,
        ],
        Login::class => [
            GenerateLoginTime::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
