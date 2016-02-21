<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class AlumnoUpdateRequest extends Request
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
            'id_detalle_institucion' => 'required',
            'id_matricula' => 'required',
            'id_grado' => 'required',
        ];
    }
}
