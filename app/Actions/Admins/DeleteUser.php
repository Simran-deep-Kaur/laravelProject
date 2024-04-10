<?php

namespace App\Actions\Admins;

class DeleteUser
{
    public function delete($user)
    {
        $imagePath = public_path('show-image/') . $user->profile_image;

        if ($user->profile_image) {
            unlink($imagePath);
        }
        $user->roles()->detach();
        $user->delete();
    }
}
