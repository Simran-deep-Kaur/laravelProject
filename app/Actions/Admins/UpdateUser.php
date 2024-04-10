<?php

namespace App\Actions\Admins;

use App\Http\Requests\ValidationAdmin;
use App\Models\User;

class UpdateUser
{
    public function update($user, array $data)
    {
        if (array_key_exists('profile_image', $data)) {
            if ($user->profile_image) {
                $image_path = public_path("show-image/") . $user->profile_image;
                unlink($image_path);
            }
            $profileImageName = $data['profile_image']?->store('uploads');
        } else {
            $profileImageName = $user->profile_image;
        }

        $data['profile_image'] = $profileImageName;
        $user->update($data);
    }
}
