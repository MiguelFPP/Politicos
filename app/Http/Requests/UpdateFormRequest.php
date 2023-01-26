<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
        $validate = [
            'creador_id' => 'required|exists:users,id',
            'nombres' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|max:255',
            'genero' => 'required|max:255',
            'direccion' => 'required|max:255',
            'tipo_zona' => 'required|distinct|in:Comuna,Vereda',
            'puesto_votacion' => 'required|max:255',
            'mensaje' => 'nullable'
        ];

        if ($this->tipo_zona == 'Comuna') {
            $validate['commune_id'] = 'required|exists:communes,id';
            $validate['quarter_id'] = 'required|exists:quarters,id';
        } else {
            $validate['township_id'] = 'required|exists:townships,id';
            $validate['sidewalk_id'] = 'required|exists:sidewalks,id';
        }

        return $validate;
    }

    public function attributes()
    {
        return [
            'creador_id' => 'creador',
            'email' => 'correo electronico',
            'telefono' => 'telefono',
            'tipo_zona' => 'tipo de zona',
            'commune_id' => 'comuna',
            'quarter_id' => 'barrio',
            'township_id' => 'vereda',
            'sidewalk_id' => 'corregimiento',
            'puesto_votacion' => 'puesto de votacion',
            'mensaje' => 'mensaje'
        ];
    }
}
