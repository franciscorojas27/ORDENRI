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
    private array $fields = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:50', 'alpha'],
            'last_name' => ['required', 'string', 'max:50', 'alpha'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[\d-]+$/'],
            'coordination_management' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'general_management' => ['required', 'integer', 'exists:general_managements,id', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
        if ($this->routeIs('admin-secure.create')) {
            $rules['resolution_area'] = ['required', 'integer', 'exists:resolution__areas,id', 'min:1'];
            $rules['job_title'] = ['required', 'integer', 'exists:job_titles,id', 'min:1'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'last_name.required' => 'El campo apellido es obligatorio.',
            'resolution_area.required' => 'El campo area de resolución es obligatorio.',
            'resolution_area.exists' => 'La area de resolución seleccionada no existe.',
            'resolution_area.min' => 'La area de resolución seleccionada no existe.',
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
            'resolution_area' => 'area de resolución',
            'coordination_management' => 'gerencia de coordinación',
            'general_management' => 'gerencia general',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
        ];
    }

}