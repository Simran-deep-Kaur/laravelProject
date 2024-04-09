<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class LogSuccessfulLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        $user = $event->user;
        $loginTime = Carbon::parse($user->login_time);
        $logoutTime = Carbon::parse($user->logout_time);
        $user->update(['active_duration' => Carbon::parse($loginTime->diffInSeconds($logoutTime))]);
     }
}
