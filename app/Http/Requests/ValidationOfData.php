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

    public function rules(): array
    {
        $emailRule = ($this->employee)
            ? Rule::unique('employees')->ignore($this->employee->id, 'id')
            : 'unique:employees,email';

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email',$emailRule],
            'gender' => 'required',
            'age' => 'nullable|integer|min:18',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}