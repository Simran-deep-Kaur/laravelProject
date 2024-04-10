<?php

namespace App\Actions\Employees;


class DeleteEmployee
{
    public function delete($employee)
    {
        $image_path = public_path("show-image/") . $employee->profile_image;

        if ($employee->profile_image) {
            unlink($image_path);
        }

        $employee->delete();
    }
}