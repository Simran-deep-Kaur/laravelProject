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

        if ($request->search) {
            $search = $request->input('search');
            $employeeQuery->where(function ($query) use ($search) {
                $query->where('employees.name', 'LIKE', "$search%")
                    ->orWhere('employees.email', 'LIKE', "$search%")
                    ->orWhere('employees.age', 'LIKE', "$search%")
                    ->orWhere('employees.gender', 'LIKE', "$search%")
                    ->orWhere('employees.age', 'LIKE', "$search%")
                    ->orWhere('users.name', 'LIKE', "$search%");
            });
        }

        if (!$request->user()->hasRole('super-admin')) {
            $users = [];

            $employees = $employeeQuery
                ->where('employees.user_id', $request->user()->id)
                ->paginate(5);
        } else {
            if ($request->filter && $request->filter !== "all") {
                $employeeQuery->where('users.id', $request->input('filter'));
            }

            $employees = $employeeQuery->paginate(5);
            $employees->appends(['search' => $request->search]);
        }

        $employees->appends(['filter' => $request->filter, 'search' => $request->search]);
        $data = EmployeeResource::collection($employees)->resolve();

        $filter = $request->filter;

        return view('employees.index', compact('data', 'users', 'employees', 'filter'));
    }

    // public function search(Request $request)
    // {
    //     $search = $request->input('search');
    //     $newemployees = Employee::join('users', 'employees.user_id', '=', 'users.id')
    //         ->select('employees.*', 'users.name as creator')
    //         ->where('employees.name', 'LIKE', "{$search}%")
    //         ->orWhere('employees.email', 'LIKE', "{$search}%")
    //         ->orWhere('employees.age', 'LIKE', "{$search}%")
    //         ->orWhere('employees.gender', 'LIKE', "{$search}%")
    //         ->orWhere('users.name', 'LIKE', "{$search}%")
    //         ->orderBy('employees.created_at', 'desc')
    //         ->paginate(5);

    //     $newdata = EmployeeResource::collection($newemployees)->resolve();

    //     return response()->json($newdata);
    // }

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
