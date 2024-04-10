<?php

namespace App\Actions\Admins;

class UpdateUser
{
    public function update($user, array $data)
    {
        if (isset($data['profile_image'])) {
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
