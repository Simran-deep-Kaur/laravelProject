<?php

namespace App\Actions\Employees;

use App\Http\Requests\ValidationOfData;
use App\Mail\NewEmployeeNotification;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;

class CreateEmployee
{
    public function create(array $data)
    {

        if (array_key_exists('profile_image', $data)) {
            $data['profile_image'] = $data['profile_image']?->store('uploads');
        }

        // $data['profile_image'] = $request->file('profile_image')?->store('uploads');
        
        $data['user_id'] = auth()->user()->id;
        $employee = Employee::create($data);

        // Mail::to($request->input('email'))->send(new NewEmployeeNotification($employee));
        return $employee;
    }
}