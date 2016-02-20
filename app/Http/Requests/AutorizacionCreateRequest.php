<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class AutorizacionCreateRequest extends Request
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
            'rd' => 'required|string',
            'nro_documento' => 'required',
            'fecha_limite'=>'required|date_format:Y/m/d',
        ];
    }
}
