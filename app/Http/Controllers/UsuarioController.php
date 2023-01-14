<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuario.index');
    }

    public function tabla()
    {
        return Datatables::of(User::query())
        ->addColumn('rol', function($col){
            return implode(",",$col->getRoleNames()->toArray());
        })
        ->editColumn('updated_at', function($col){
            return Carbon::parse($col->updated_at)->format('d-m-Y H:i:s');
        })
        ->addColumn('acciones', function($col){
            $btn =  '<a href="'.route('usuarios.ver', $col->id).'" class="btn btn-outline-secondary" title="Ver usuario"><i class="fa fa-eye"></i></a>';
            if(Auth::user()->hasRole('administrador')) {
                $btn .= '<a href="'.route('usuarios.actualizar', $col->id).'" class="btn btn-outline-primary m-2" title="Editar usuario"><i class="fa fa-edit"></i></a>';
                if($col->id != 1) {
                    $btn .= '<a href="'.route('usuarios.eliminar', $col->id).'" class="btn btn-outline-danger" title="Eliminar usuario"><i class="fa fa-times"></i></a>';
                }
            }
            return $btn;
        })
        ->rawColumns(['acciones'])
        ->make(true);
    }

    public function crear()
    {
        return view('usuario.crear');
    }

    public function crear_guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required',
            'password' => 'nullable'
        ]);

        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = $request->password ?? Hash::make('Password@1!');
        $usuario->save();

        if($request->rol == 'admin') {
            $usuario->assignRole('administrador');
        } else {
            $usuario->assignRole('simple');
        }

        Alert::success('Formulario', 'Se ha creado el usuario con exito!');
        return redirect()->route('usuarios');
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = User::find($id);
        if(!$usuario) {
            Alert::error('Usuario', 'No se ha encontrado el usuario solicitado.');
            return redirect()->route('usuarios');
        }

        $usuario->rol = implode(",",$usuario->getRoleNames()->toArray());
        return view('usuario.actualizar', compact('usuario'));
    }

    public function actualizar_guardar(Request $request, $id)
    {
        $usuario = User::find($id);
        if(!$usuario) {
            Alert::error('Usuario', 'No se ha encontrado el usuario solicitado.');
            return redirect()->route('usuarios');
        }

        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required',
            'password' => 'nullable',
        ]);

        $usuario->name = $request->nombre;
        $usuario->email = $request->email;

        if($request->password) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->save();

        if($request->rol == 'admin') {
            $usuario->assignRole('administrador');
            $usuario->removeRole('simple');
        } else {
            $usuario->assignRole('simple');
            $usuario->removeRole('administrador');
        }

        Alert::success('Usuario', 'Se ha actualizado el usuario con exito!');
        return redirect()->route('usuarios');
    }

    public function ver(Request $request, $id)
    {
        $usuario = User::find($id);
        if(!$usuario) {
            Alert::error('Usuario', 'No se ha encontrado el usuario solicitado.');
            return redirect()->route('usuarios');
        }

        $usuario->rol = implode(",",$usuario->getRoleNames()->toArray());
        return view('usuario.ver', compact('usuario'));
    }

    public function eliminar(Request $request, $id)
    {
        $usuario = User::find($id);
        if(!$usuario) {
            Alert::error('Usuario', 'No se ha encontrado el usuario solicitado.');
            return redirect()->route('usuarios');
        }

        $usuario->rol = implode(",",$usuario->getRoleNames()->toArray());
        return view('usuario.eliminar', compact('usuario'));
    }

    public function eliminar_confirmar(Request $request, $id)
    {
        $usuario = User::find($id);
        if(!$usuario) {
            Alert::error('Usuario', 'No se ha encontrado el usuario solicitado.');
            return redirect()->route('usuarios');
        }

        $usuario->delete();

        Alert::success('Usuario', 'Se ha eliminado el usuario con exito.');
        return redirect()->route('usuarios');
    }
}
