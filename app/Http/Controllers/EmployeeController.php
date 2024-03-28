<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Http\Requests\ValidationOfData;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        //     return EmployeeResource::collection($request->user()->employees);
        // dd(EmployeeResource::collection($request->user()->employees));
        return view('index', ['employees' => EmployeeResource::collection($request->user()->employees)]);
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
        // dd($data);
        return view('index', ['employees' => new EmployeeResource($employee)])->with('success', 'New user added sucessfully.');
        // return redirect()->route('employees')->with('success', 'New user added successfully');
    }

    public function show(Employee $employee)
    {
        // return view('show', compact('employee'));
        return view('show', ['employee' => new EmployeeResource($employee)]);
    }

    public function edit(Employee $employee)
    {
        return view('edit', ['employee' => new EmployeeResource($employee)]);
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
        return view('index', ['employees' => new EmployeeResource(($employee))])->with('success' . 'User updated successfully');
        // return redirect()->route('employees')->with('success', 'User updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees')->with('success', 'User deleted successfully');
    }
}
