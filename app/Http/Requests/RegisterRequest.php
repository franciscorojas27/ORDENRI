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
    public function rules()
{
    return [
        'name' => ['required', 'string', 'max:50', 'alpha'],
        'last_name' => ['required', 'string', 'max:50', 'alpha'],
        'job_title' => ['required', 'integer', 'exists:job_titles,id', 'min:1'],
        'phone' => ['required', 'string', 'max:25', 'regex:/^[\d-]+$/'],
        'coordination_management' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
        'general_management' => ['required', 'integer', 'exists:general_managements,id', 'min:1'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::defaults()],
    ];
}

public function messages()
{
    return [
        'name.required' => 'El campo nombre es obligatorio.',
        'last_name.required' => 'El campo apellido es obligatorio.',
        'job_title.required' => 'El campo cargo es obligatorio.',
        'job_title.exists' => 'El cargo seleccionado no existe.',
        'phone.required' => 'El campo teléfono es obligatorio.',
        'phone.regex' => 'El campo teléfono solo puede contener números y guiones.',
        'coordination_management.required' => 'El campo gerencia de coordinación es obligatorio.',
        'coordination_management.regex' => 'El campo gerencia de coordinación solo puede contener letras y espacios.',
        'general_management.required' => 'El campo gerencia general es obligatorio.',
        'general_management.exists' => 'La gerencia general seleccionada no existe.',
        'email.required' => 'El campo correo electrónico es obligatorio.',
        'email.email' => 'El campo correo electrónico debe ser una dirección válida.',
        'email.unique' => 'El correo electrónico ya está en uso.',
        'password.required' => 'El campo contraseña es obligatorio.',
        'password.confirmed' => 'La confirmación de la contraseña no coincide.',
    ];
}

public function attributes()
{
    return [
        'name' => 'nombre',
        'last_name' => 'apellido',
        'job_title' => 'cargo',
        'phone' => 'teléfono',
        'coordination_management' => 'gerencia de coordinación',
        'general_management' => 'gerencia general',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
    ];  
    }
       
}