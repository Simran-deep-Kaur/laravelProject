<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidationAdmin extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $emailRule = ($this->user)
            ? Rule::unique('users')->ignore($this->user->id, 'id')
            : 'unique:users,email';

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', $emailRule],
            'gender' => 'nullable',
            'age' => 'nullable|integer|min:18',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}