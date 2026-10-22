<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ];
    }
}
