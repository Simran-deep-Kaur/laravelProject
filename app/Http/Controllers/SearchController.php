<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $result = Employee::where('name', 'like', "%$search%")->get();
        return view('employees.index', ['result' => $result]);
    }
}
