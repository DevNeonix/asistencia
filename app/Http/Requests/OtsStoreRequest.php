<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtsStoreRequest extends FormRequest
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
            'nro_orden' => "required|unique:orden_trabajo",
//            'producto_fabricar' => "required",
            'centro_costo_id' => "required",
            'cliente' => "required",
        ];
    }
}
