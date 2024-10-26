<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateControlUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedAuthorization()
    {   
        return redirect()->route('admin-secure.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', 'alpha'],
            'last_name' => ['required', 'string', 'max:50', 'alpha'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'job_title_id' => ['required', 'exists:job_titles,id', 'integer', 'min:1'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[\d\+\-\.\s]+$/'],
            'last_connection' => ['required', 'date'],
            'created_at' => ['required', 'date'],
            'password_may_expire' => ['required', 'boolean'],
            'password_may_expire_at' => ['required', 'date'],
            'ip_address' => ['required', 'string', 'max:15', 'ipv4'],
            'is_blocked' => ['required', 'boolean'],
            'group' => ['required', 'boolean'],
            'coordination_management' => ['required', 'string', 'max:50'],
            'general_management_id' => ['required', 'exists:general_managements,id', 'integer', 'min:1'],
        ];
    }
}

