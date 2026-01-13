<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoUpdateRequest extends FormRequest
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
            'ci' => 'unique:empleados,ci,' . $this->empleado->id,
            'correo' => 'unique:empleados,correo,' . $this->empleado->id,
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
