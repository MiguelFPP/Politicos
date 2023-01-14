<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function lista_usuarios(Request $request)
    {
        $usuarios = User::select(['id', 'name']);
        if($busqueda = $request->search){
            $usuarios = $usuarios->whereRaw('LOWER(name) like "%' . strtolower($busqueda) . '%"');
        }

        return $usuarios->get(10)->map(function($usuario){
            return [
                "id" => $usuario->id,
                "text" => $usuario->name
            ];
        });
    }
}
