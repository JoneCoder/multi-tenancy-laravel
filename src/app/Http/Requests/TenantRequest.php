<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'name'          => ['required', 'string', 'max:191'],
            'email'         => ['required', 'email'],
            'subdomain'     => ['required', 'unique:tenants'. ($this->id ? ",id,$this->id" : '')],
            'db_name'       => ['required', 'unique:tenants'. ($this->id ? ",id,$this->id" : '')]
        ];
    }
}
