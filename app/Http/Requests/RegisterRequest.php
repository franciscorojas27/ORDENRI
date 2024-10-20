<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    { 
        return [
            [
                'name' => ['required', 'string', 'max:50', 'alpha'],
                'last_name' => ['required', 'string', 'max:50', 'alpha'],
                'job_title' => ['required', 'exists:job_titles,id', 'integer', 'min:1'],
                'phone' => ['required', 'string', 'max:25', 'regex:/^[\d-]+$/'],
                'coordination_management' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
                'general_management' => ['required', 'exists:general_managements,id', 'integer', 'min:1'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
            ],
            [
                'job_title.required' => 'El campo cargo es obligatorio.',
                'general_management.required' => 'El campo gerencia general es obligatorio.',
                'coordination_management.required' => 'El campo gerencia de coordinación es obligatorio.',
                'coordination_management.regex' => 'El campo gerencia de coordinación solo debe contener letras.',
            ]
        ];
    }
}
