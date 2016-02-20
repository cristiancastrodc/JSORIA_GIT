<?php

namespace JSoria\Http\Requests;

use JSoria\Http\Requests\Request;

class UserUpdateRequest extends Request
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
            'dni' => 'required|numeric|digits:8',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'tipo' => 'required|in:Administrador,Secretaria,Cajera,Tesorera',
            'permisos' => 'required|array',
            'usuario_login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
