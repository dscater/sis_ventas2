<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'ci' => 'unique:empleados,ci',
            'correo' => 'unique:empleados,correo',
        ];
    }

    public function messages()
    {
        return [
            'ci.unique' => 'Ese número de C.I. ya se encuentra registrado.',
            'correo.unique' => 'Este correo ya se encuentra registrado.',
        ];
    }
}
