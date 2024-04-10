<?php

namespace App\Actions\Admins;

use App\Models\Role;
use App\Models\User;

class CreateUser
{
    public function create(array $data)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $data['profile_image']?->store('uploads');
        }

        $data['password'] = bcrypt('12345678');
        $data['active_time'] = now();
        $user = User::create($data);

        $user->roles()->attach(
            Role::where('name', 'admin')->first()->id
        );
        return $user;
    }
}
