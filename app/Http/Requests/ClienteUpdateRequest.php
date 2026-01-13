<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
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
            'ci' => 'unique:clientes,ci,' . $this->cliente->id,
        ];
    }

    public function messages()
    {
        return [
            'ci.unique' => 'Ese número de C.I. ya se encuentra registrado.',
        ];
    }
}
