<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class FormularioController extends Controller
{
    public function index()
    {
        return view('formulario.index');
    }

    public function tabla()
    {
        return Datatables::of(Formulario::query())
        ->addColumn('creador', function($col){
            $creador = User::find($col->propietario_id);
            return $creador ? $creador->name : '-';
        })
        ->editColumn('nombre', function($col){
            return $col->nombre.' '.$col->apellido;
        })
        ->editColumn('updated_at', function($col){
            return Carbon::parse($col->updated_at)->format('d-m-Y H:i:s');
        })
        ->addColumn('acciones', function($col){
            $btn =  '<a href="'.route('formularios.ver', $col->id).'" class="btn btn-outline-secondary" title="Ver formulario"><i class="fa fa-eye"></i></a>';
            if(Auth::user()->hasRole('administrador')) {
                $btn .= '<a href="'.route('formularios.actualizar', $col->id).'" class="btn btn-outline-primary m-2" title="Editar formulario"><i class="fa fa-edit"></i></a>';
                $btn .= '<a href="'.route('formularios.eliminar', $col->id).'" class="btn btn-outline-danger" title="Eliminar formulario"><i class="fa fa-times"></i></a>';
            }
            return $btn;
        })
        ->rawColumns(['acciones'])
        ->make(true);
    }

    public function crear()
    {
        return view('formulario.crear');
    }

    public function crear_guardar(Request $request)
    {
        $request->validate([
            'creador_id' => 'required|exists:users,id',
            'nombres' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|max:255',
            'genero' => 'required|max:255',
            'direccion' => 'required|max:255',
            'tipo_zona'=>'required',
            'zona' => 'required|max:255',
            'puesto_votacion' => 'required|max:255',
            'mensaje' => 'nullable'
        ]);

        $formulario = new Formulario();
        $formulario->propietario_id = $request->creador_id;
        $formulario->nombre = $request->nombres;
        $formulario->apellido = $request->apellidos;
        $formulario->email = $request->email;
        $formulario->telefono = $request->telefono;
        $formulario->genero = $request->genero;
        $formulario->direccion = $request->direccion;
        $formulario->tipo_zona=$request->tipo_zona;
        $formulario->zona = $request->zona;
        $formulario->puesto_votacion = $request->puesto_votacion;
        $formulario->mensaje = $request->mensaje;
        $formulario->save();

        Alert::success('Formulario', 'Se ha creado el formulario con exito!');
        return redirect()->route('formularios');
    }

    public function actualizar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if(!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;
        return view('formulario.actualizar', compact('formulario'));
    }

    public function actualizar_guardar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if(!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $request->validate([
            'creador_id' => 'required|exists:users,id',
            'nombres' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|max:255',
            'genero' => 'required|max:255',
            'direccion' => 'required|max:255',
            'zona' => 'required|max:255',
            'puesto_votacion' => 'required|max:255',
            'mensaje' => 'nullable'
        ]);

        $formulario->propietario_id = $request->creador_id;
        $formulario->nombre = $request->nombres;
        $formulario->apellido = $request->apellidos;
        $formulario->email = $request->email;
        $formulario->telefono = $request->telefono;
        $formulario->genero = $request->genero;
        $formulario->direccion = $request->direccion;
        $formulario->zona = $request->zona;
        $formulario->puesto_votacion = $request->puesto_votacion;
        $formulario->mensaje = $request->mensaje;
        $formulario->save();

        Alert::success('Formulario', 'Se ha actualizado el formulario con exito!');
        return redirect()->route('formularios');
    }

    public function ver(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if(!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;
        return view('formulario.ver', compact('formulario'));
    }

    public function eliminar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if(!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;
        return view('formulario.eliminar', compact('formulario'));
    }

    public function eliminar_confirmar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if(!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->delete();

        Alert::success('Formulario', 'Se ha eliminado el formulario con exito.');
        return redirect()->route('formularios');
    }
}
