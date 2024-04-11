<?php

namespace App\Http\Controllers;

use App\Actions\Employees\CreateEmployee;
use App\Actions\Employees\DeleteEmployee;
use App\Actions\Employees\UpdateEmployee;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\ValidationOfData;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {

        $users = User::all();

        $employeeQuery = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.*', 'users.name as creator')
            ->orderBy('employees.created_at', 'desc');

        if (!$request->user()->hasRole('super-admin')) {
            $users = [];

            $employees = $employeeQuery
                ->where('employees.user_id', $request->user()->id)
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

    public function buttonClick(Request $request)
    {
        $request->user()->update(['active_time' => now()]);
    }

    public function store(ValidationOfData $request, CreateEmployee $createEmployee)
    {
        $employee = $createEmployee->create($request->all());

        return redirect()->route('employees')->with('success', 'Employee created successfully');
    }

    public function show(Request $request, Employee $employee)
    {
        $employee = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->where('employees.id', $employee->id)
            ->select('employees.*', 'users.name as creator')
            ->first();

        return view('employees.show', ['employee' => (new EmployeeResource($employee))->resolve()]);
    }

    public function edit(Request $request, Employee $employee)
    {
        $employee = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->where('employees.id', $employee->id)
            ->select('employees.*', 'users.name as creator')
            ->first();

        return view('employees.edit', ['employee' => new EmployeeResource($employee)]);
    }


    public function update(ValidationOfData $request, Employee $employee, UpdateEmployee $updateEmployee)
    {
        $employee = $updateEmployee->update($employee, $request->all());

        return redirect()->route('employees')->with('success', 'User updated successfully');
    }

    public function destroy(Employee $employee, DeleteEmployee $deleteEmployee)
    {
        $employee = $deleteEmployee->delete($employee);

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
