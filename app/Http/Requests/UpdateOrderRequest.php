<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\User;
use function PHPUnit\Framework\isNull;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\ValidationException;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('isAdmin', $this->user()) || $this->user()->can('isSupervisor', $this->user());
    }

    protected function failedAuthorization()
    {
        throw ValidationException::withMessages([
            'authorization' => 'No tienes permiso para realizar esta acción.',
        ]);
    }
    private array $fields = [];

    public function __construct()
    {
        $this->fields = [
            'created_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'start_at' => [
                'exclude_if:start_at,' . config('validation.text_for_start_at_edit'),
                'date_format:Y-m-d H:i:s',
                'after:created_at',
                'after_or_equal:start_at',
            ],
            'end_at' => [
                'exclude_if:end_at,' . config('validation.text_for_end_at_edit'),
                'date_format:Y-m-d H:i:s',
                'after:created_at',
                'after_or_equal:start_at',
            ],
            'status_id' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'string', 'max:255'],
            'resolution_area_id' => ['required', 'string', 'max:255'],
            'responsible_id' => ['nullable', 'integer', 'max:255'],
            'applicant_to_id' => ['nullable', 'integer', 'max:255'],
            'client_description' => ['required', 'string', 'max:500'],
            'description' => ['string', 'max:500'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->fields;
    }
    public function messages(): array
    {
        return [
            'created_at.date_format' => 'La :attribute no tiene el formato correcto',
        ];
    }
    /**
     * Custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'created_at' => 'fecha de creación',
            'start_at' => 'fecha de inicio',
            'end_at' => 'fecha de finalización',
            'status_id' => 'estatus',
            'type_id' => 'tipo',
            'responsible_id' => 'Supervisor',
            'resolution_area_id' => 'áreas de solución',
            'applicant_to_id' => 'responsable',
            'client_description' => 'descripción del solicitante',
            'description' => 'actividad',
        ];
    }
    /**
     * Actualiza los campos start_at y end_at dependiendo del estatus actual.
     * Si el estatus es 1, se eliminan start_at y end_at.
     * Si el estatus es 2, se establece start_at en la fecha actual y se elimina end_at.
     * Si el estatus es 3, se establece end_at en la fecha actual.
     * Si el estatus es 5, 6, 7 o 8, se establece end_at en la fecha actual y si start_at es nulo, se establece en la fecha actual.
     * Luego, si el usuario tiene permisos de administrador o supervisor, se devuelve el array de campos solicitados, de lo contrario, se lanza una excepción de validación.
     * @return array<string, mixed>
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateFields()
    {
        if ($this->filled('status_id')) {
            $statusId = $this->input('status_id');
            if ($statusId == 1) {
                $this->merge([
                    'responsible_id' => null,
                    'applicant_to_id' => null,
                    'start_at' => null,
                    'end_at' => null
                ]);
            } elseif ($statusId == 2) {
                $this->merge([
                    'start_at' => now(),
                    'end_at' => null,
                ]);
                if (!$this->filled('applicant_to_id')) {
                    throw ValidationException::withMessages([
                        'applicant_to_id' => 'El campo responsable es obligatorio.',
                    ]);
                }
            } elseif ($statusId == 3) {
                $this->merge([
                    'start_at' => $this->input('start_at') == config('validation.text_for_start_at_edit') ? now() : $this->input('start_at'),
                    'end_at' => now(),
                ]);
                if (!$this->filled('applicant_to_id')) {
                    throw ValidationException::withMessages([
                        'applicant_to_id' => 'El campo responsable es obligatorio.',
                    ]);
                }
            } elseif (in_array($statusId, [5, 6, 7, 8])) {

                $this->merge([
                    'start_at' => $this->validDate('start_at', config('validation.text_for_start_at_edit')) ?? now(),
                    'end_at' => $this->validDate('end_at', config('validation.text_for_end_at_edit')) ?? now(),
                ]);
            }
        }

        if ($this->user()->can('isAdmin', $this->user()) || $this->user()->can('isSupervisor', $this->user())) {
            $data = $this->except(['order_id', 'name']);
            return $data;
        } else {
            throw ValidationException::withMessages([
                'authorization' => 'No tienes permiso para realizar esta acción.',
            ]);
        }
    }


    /**
     * Valida si el campo tiene un valor de fecha válido.
     * Devuelve null si el campo tiene el texto 'No iniciado' (o definido en la configuración).
     * 
     * @param string $field
     * @return mixed
     */
    private function validDate($field, $invalidText)
    {
        $value = $this->input($field);
        return $value === $invalidText ? null : $value;
    }
}
