<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalStoreRequest extends FormRequest
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'doc_ide' => 'required|numeric|unique:personal|min:8',
            'tipo' => 'required',
            'remuneracion' => 'required|numeric',
            'asignacion_familiar' => 'required|numeric',
        ];
    }
}
