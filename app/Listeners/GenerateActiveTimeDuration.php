<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class GenerateActiveTimeDuration
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        $user->update(['logout_time' => now()]);
        $loginTime = Carbon::parse($user->login_time);
        $logoutTime = Carbon::parse($user->logout_time);
        
        $user->update([
            'active_duration' => Carbon::parse($loginTime->diffInSeconds($logoutTime))
        ]);
     }
}
