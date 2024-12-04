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
            'client_id' => ['required', 'string', 'max:255'],
            'id' => ['required', 'string', 'max:255'],
            'created_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'start_at' => [
                'required',
                function ($attribute, $value, $fail) {
                    $this->dateValidation($attribute, $value, $fail, "No iniciado");
                },
                'after_or_equal:create_at'
            ],
            'end_at' => [
                'required',
                function ($attribute, $value, $fail) {
                    $this->dateValidation($attribute, $value, $fail, "No finalizado");
                },
                'after_or_equal:start_at'
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
            'client_id' => 'solicitante',
            'id' => 'Número de orden',
            'created_at' => 'fecha de creación',
            'start_at' => 'fecha de inicio',
            'end_at' => 'fecha de finalización',
            'status_id' => 'estatus',
            'type_id' => 'tipo',
            'responsible_id' => 'Supervisor',
            'resolution_area_id' => 'áreas de solución',
            'applicant_To_id' => 'responsable',
            'client_description' => 'descripción del solicitante',
            'description' => 'actividad',
        ];
    }
    private function dateValidation($attribute, $value, $fail, $text)
    {
        if ($value !== $text && !Carbon::hasFormat($value, 'Y-m-d H:i:s')) {
            $fail("La :attribute debe ser una fecha válida.");
        }
    }
    public function updateFields()
    {
        if ($this->filled('status_id')) {
            $statusId = $this->input('status_id');
            if ($statusId == 1) {
                if ($this->input('applicant_to_id') !== null) {
                    $this->merge([
                        'applicant_to_id' => null,
                    ]);
                }
                $this->merge([
                    'start_at' => null,
                    'end_at' => null
                ]);
            } elseif ($statusId == 2) {
                $this->merge([
                    'start_at' => now(),
                    'end_at' => null,
                ]);
            } elseif ($statusId == 3) {
                $this->merge([
                    'end_at' => now(),
                ]);
            } elseif (in_array($statusId, [5, 6, 7, 8])) {

                if (is_null($this->input('start_at'))) {
                    $this->merge(['start_at' => now()]);
                }
                $this->merge([
                    'end_at' => now(),
                ]);
            }
        }


        if ($this->user()->can('isAdmin', $this->user()) || $this->user()->can('isSupervisor', $this->user())) {
            return $this->all();
        } else {
            throw ValidationException::withMessages([
                'authorization' => 'No tienes permiso para realizar esta acción.',
            ]);
        }
    }
}
