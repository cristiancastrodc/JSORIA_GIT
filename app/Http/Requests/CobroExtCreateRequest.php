<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class CobroExtCreateRequest extends Request
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
            'descripcion_extr' => 'required|string',
            'monto' => 'required|numeric',
            'cliente_extr' => 'required|string',
        ];
    }
}
