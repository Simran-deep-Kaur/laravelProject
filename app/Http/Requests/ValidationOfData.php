<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidationOfData extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $employee = $this->route('employee');
        $rules = [
            'POST' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees',
                'gender' => 'required',
                'age' => 'nullable|integer|min:18',
                'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            ],
            'PUT' => [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('employees')->ignore($employee->email, 'email')
                ],
                'gender' => 'required',
                'age' => 'nullable|integer|min:18',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]
        ];
        return $rules[$this->method()];
    }
}
