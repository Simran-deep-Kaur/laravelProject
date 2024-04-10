<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
USE Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class GenerateLoginTime
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        auth()->user()->update(['login_time' => now()]);
    }
}
