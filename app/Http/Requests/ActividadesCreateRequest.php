<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class ActividadesCreateRequest extends Request
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
          /*
            'id_detalle_institucion' => 'required|numeric',
            'nombre' => 'required',
            'monto' => 'required|numeric',
          */
        ];
    }
}
