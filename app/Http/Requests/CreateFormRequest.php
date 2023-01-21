<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
            'creador_id' => 'required|exists:users,id',
            'nombres' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|max:255',
            'genero' => 'required|max:255',
            'direccion' => 'required|max:255',
            'tipo_zona' => 'required|distinct|in:Comuna,Vereda',
            'commune_id' => 'required_if:tipo_zona,Comuna|exists:communes,id',
            'quarter_id' => 'required_if:tipo_zona,Comuna|exists:quarters,id',
            'township_id' => 'required_if:tipo_zona,Vereda|exists:townships,id',
            'sidewalk_id' => 'required_if:tipo_zona,Vereda|exists:sidewalks,id',
            'puesto_votacion' => 'required|max:255',
            'mensaje' => 'nullable'
        ];
    }
}
