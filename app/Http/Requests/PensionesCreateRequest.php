<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class PensionesCreateRequest extends Request
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
            'nombre' => 'required|string',
            'monto' => 'required|numeric',
            'tipo' => 'required|in:pension',
            'estado' => 'required|boolean',
            'fecha_inicio' => 'required|date_format:Y/m/d',
            'fecha_fin' => 'required|date_format:Y/m/d|after:fecha_inicio',
            'destino' => 'required|numeric',
            'id_detalle_institucion' => 'required|numeric',
        ];
    }
}
