<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class EgresoCreateRequest extends Request
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
            'id_institucion' => 'required|numeric',
            'tipo_comprobante' => 'required|numeric',
            'numero_comprobante' => 'required|numeric',
            'id_tesorera' => 'required|numeric',
            'fecha' => 'required|date_format:Y/m/d',
            
        ];
    }
}
