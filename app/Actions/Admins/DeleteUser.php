<?php

namespace App\Actions\Admins;

use App\Models\User;

class DeleteUser
{
    public function handle($user)
    {
        $imagePath = public_path('show-image/') . $user->profile_image;

        if ($user->profile_image) {
            unlink($imagePath);
        }
        $user->roles()->detach();
        $user->delete();
    }
}
