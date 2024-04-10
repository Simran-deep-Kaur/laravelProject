<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Role;

class GenerateLoginTimeRegistered
{

    public function handle(Registered $event)
    {
        $user = $event->user;
        $user->update(['login_time' => now()]);
        $user->roles()->attach(
            Role::where('name', 'admin')->first()->id
        );
    }
}
