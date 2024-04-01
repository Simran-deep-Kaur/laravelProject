<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\ValidationOfData;
use App\Http\Resources\EmployeeResource;
use App\Mail\NewEmployeeNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->hasRole('super-admin')) {
            $users = User::all();
            if ($request->has('filter')) {
                $filter = $request->input('filter');
                if ($filter == 'all') {
                    $data = EmployeeResource::collection(Employee::all())->resolve();
                } else {
                    $user = User::findOrFail($filter);
                    $data = EmployeeResource::collection($user->employees)->resolve();
                }
            } else {
                $data = EmployeeResource::collection(Employee::all())->resolve();
            }
        } else {
            $users = collect([$request->user()]);
            // dd($request->user());
            $data = EmployeeResource::collection($request->user()->employees)->resolve();
        }

        return view('employees.index', compact('data', 'users'));
    }
    
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [Rule::unique('employees')->ignore($request->previousEmail, 'email')],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first('email')]);
        }

        return response()->json(['status' => 'success']);
    }

    public function store(ValidationOfData $request)
    {
        $profileImage = $request->file('profile_image');

        $profileImageName = null;

        if (!empty($profileImage)) {
            $profileImageName = $profileImage->getClientOriginalName();
            $profileImage->store('public/uploads');
        }

        $data = $request->all();
        $data['profile_image'] = $profileImageName;

        $employee = $request->user()->employees()->create($data);

        Mail::to($request->input('email'))->send(new NewEmployeeNotification($employee));

        return redirect()->route('employees')->with('success', 'Employee created successfully');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', ['employee' => new EmployeeResource($employee)]);
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', ['employee' => new EmployeeResource($employee)]);
    }

    public function update(ValidationOfData $request, Employee $employee)
    {
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $profileImageName = $profileImage->getClientOriginalName();
            $profileImage->store('public/uploads');
            $employee->profile_image = $profileImageName;
        } else {
            $profileImageName = $employee->profile_image;
        }

        $data = $request->all();
        $data['profile_image'] = $profileImageName;
        $employee->update($data);
        return redirect()->route('employees')->with('success', 'User updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees')->with('success', 'User deleted successfully');
    }
}
