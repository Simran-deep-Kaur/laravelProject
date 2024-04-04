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
use Faker\Core\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        $employeeQuery = Employee::join(
            'users',
            'employees.user_id',
            '=',
            'users.id'
        )->select('employees.*', 'users.name as creator')->orderBy('employees.created_at', 'desc');

        if (!$request->user()->hasRole('super-admin')) {
            $users = [];

            $employees = $employeeQuery->where('employees.user_id', $request->user()->id)
                ->get();
        } else {
            $employees = (!$request->has('filter') || ($request->input('filter') == "all"))
                ? $employeeQuery->get()
                : $employeeQuery->where('users.id', $request->input('filter'))->get();
        }

        $data = EmployeeResource::collection($employees)->resolve();

        return view('employees.index', compact('data', 'users'));
    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [Rule::unique('employees')->ignore($request->Id, 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first('email')]);
        }

        return response()->json(['status' => 'success']);
    }

    public function store(ValidationOfData $request)
    {
        $data = $request->all();

        $data['profile_image'] = $request->file('profile_image')?->store('uploads');

        $employee = $request->user()->employees()->create($data);

        // Mail::to($request->input('email'))->send(new NewEmployeeNotification($employee));

        return redirect()->route('employees')->with('success', 'Employee created successfully');
    }

    public function show(Request $request, Employee $employee)
    {
        $employee = Employee::leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->where('employees.id', $employee->id)
            ->select('employees.*', 'users.name as creator')
            ->first();

        return view('employees.show', ['employee' => new EmployeeResource($employee)]);
    }

    public function edit(Request $request, Employee $employee)
    {
        $employee = Employee::leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->where('employees.id', $employee->id)
            ->select('employees.*', 'users.name as creator')
            ->first();

        return view('employees.edit', ['employee' => new EmployeeResource($employee)]);
    }

    public function update(ValidationOfData $request, Employee $employee)
    {
        if ($request->hasFile('profile_image')) {
           if($employee->profile_image){
            $image_path = public_path("show-image/") . $employee->profile_image;
            unlink($image_path);
           }
            $profileImageName = $request->file('profile_image')?->store('uploads');
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

        $image_path = public_path("show-image/") . $employee->profile_image;

        if ($employee->profile_image) {
            unlink($image_path);
        }
        
        $employee->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
