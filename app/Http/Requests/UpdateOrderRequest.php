<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
class UpdateOrderRequest extends FormRequest
{
    private array $fields = [];

    public function __construct()
    {
        $this->fields = [
            'client_id' => ['required', 'string', 'max:255'],
            'id' => ['required', 'string', 'max:255'],
            'created_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'start_at' => ['required', function ($attribute, $value, $fail) {
                $this->dateValidation($attribute, $value, $fail, "No iniciado");
            }],   
            'end_at' => ['required', function ($attribute, $value, $fail) {
                $this->dateValidation($attribute, $value, $fail, "No finalizado");
            }],
            'status_id' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'string', 'max:255'],
            'responsible_id' => ['string', 'max:255'],
            'resolution_area_id' => ['required', 'string', 'max:255'],
            'applicant_to_id' => ['string', 'max:255'],
            'client_description' => ['required', 'string', 'max:500'],
            'description' => ['string', 'max:500'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('isAdmin', $this->user());    
    }
    protected function failedAuthorization()
    {
        throw ValidationException::withMessages([
            'authorization' => 'No tienes permiso para realizar esta acción.',
        ]);
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
        if ($value !== $text && !$this->isValidDateFormat($value)) {
            $fail("La :attribute debe ser una fecha válida.");
        }
    }
    private function isValidDateFormat(string $date): bool
    {
        return Carbon::hasFormat($date, 'Y-m-d H:i:s');
    }
    public function updateFields(){
        if ($this->user()->can('isAdmin', $this->user())) {
            return $this->all();
        } else {
            throw ValidationException::withMessages([
                'authorization' => 'No tienes permiso para realizar esta acción.']);
        }
    }    
    public function passedValidation()
    {
        // Si 'start_at' es "No iniciado", establecemos null para evitar que pase al controlador
        if ($this->input('start_at') === 'No iniciado') {
            $this->request->set('start_at', null);
        }

        // Si 'end_at' es "No Finalizado", establecemos null para evitar que pase al controlador
        if ($this->input('end_at') === 'No finalizado') {
            $this->request->set('end_at', null);
        }
        $this->request->remove('client_id');
    }
    
}
