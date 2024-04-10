<?php

namespace App\Actions\Employees;

class UpdateEmployee
{
    public function update($employee, array $data)
    {
        if (isset($data['profile_image'])) {
            if ($employee->profile_image) {
                $image_path = public_path("show-image/") . $employee->profile_image;
                unlink($image_path);
            }
            $profileImageName = $data['profile_image']?->store('uploads');
        } else {
            $profileImageName = $employee->profile_image;
        }

        $data['profile_image'] = $profileImageName;
        $employee->update($data);

    }
}