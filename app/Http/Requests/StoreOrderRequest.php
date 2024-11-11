<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => ['required', 'string', 'max:100','exists:users,id'],
            'resolution_areas' => ['required', 'string', 'max:255','exists:resolution__areas,id'],
            'types' => ['required', 'string', 'max:255','exists:types,id'],
            'description' => ['required', 'string', 'max:500'],
        ];
    }
    public function messages(): array
    {
        return [
            'client.required' => 'El campo cliente es obligatorio.',
            'types.required' => 'El campo tipo de orden es obligatorio.',
            'resolution_areas.required' => 'El campo area de solución es obligatorio.',
            'description.required' => 'El campo descripción es obligatorio.',
        ];
    }
}
