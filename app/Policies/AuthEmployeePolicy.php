<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class AuthEmployeePolicy
{

    public function view(User $user, Employee $employee): bool
    {
         
        return $user->hasRole('super-admin') || $user->id === $employee->user_id;
      
    }
   
}
