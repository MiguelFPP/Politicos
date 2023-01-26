<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Commune;
use App\Models\Formulario;
use App\Models\Quarter;
use App\Models\Sidewalk;
use App\Models\Township;
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

    public function allForms()
    {
        $user = Auth::user();

        if ($user->hasRole('administrador')) {
            $forms = Formulario::all();
        } else {
            $forms = Formulario::where('propietario_id', $user->id)->get();
        }
        /* forms have forms->location is a json, Browse to get the names of the locations from the database and change the ids for the name obtained */
        foreach ($forms as $form) {
            $location = json_decode($form->location);
            if ($form->tipo_zona == 'Comuna') {
                $commune = Commune::find($location->commune_id);
                $quarter = Quarter::find($location->quarter_id);
                $form->location = $commune->name . ' - ' . $quarter->name;
            } else {
                $township = Township::find($location->township_id);
                $sidewalk = Sidewalk::find($location->sidewalk_id);
                $form->location = $township->name . ' - ' . $sidewalk->name;
            }

            /* and inser button with actions, update, delete */

            $form->acciones = '<a href="' . route('formularios.actualizar', $form->id) . '" class="btn btn-outline-primary m-2" title="Editar formulario"><i class="fa fa-edit"></i></a>'
                . '<a href="' . route('formularios.eliminar', $form->id) . '" class="btn btn-outline-danger" title="Eliminar formulario"><i class="fa fa-times"></i></a>';
        }



        return response()->json($forms);
    }

    public function tabla()
    {
        return Datatables::of(Formulario::query())
            ->addColumn('creador', function ($col) {
                $creador = User::find($col->propietario_id);
                return $creador ? $creador->name : '-';
            })
            ->editColumn('nombre', function ($col) {
                return $col->nombre . ' ' . $col->apellido;
            })
            ->editColumn('updated_at', function ($col) {
                return Carbon::parse($col->updated_at)->format('d-m-Y H:i:s');
            })
            ->addColumn('acciones', function ($col) {
                $btn =  '<a href="' . route('formularios.ver', $col->id) . '" class="btn btn-outline-secondary" title="Ver formulario"><i class="fa fa-eye"></i></a>';
                if (Auth::user()->hasRole('administrador')) {
                    $btn .= '<a href="' . route('formularios.actualizar', $col->id) . '" class="btn btn-outline-primary m-2" title="Editar formulario"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="' . route('formularios.eliminar', $col->id) . '" class="btn btn-outline-danger" title="Eliminar formulario"><i class="fa fa-times"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function crear()
    {
        $communes = Commune::select('id', 'name')->get();
        $townships = Township::select('id', 'name')->get();

        return view('formulario.crear', compact('communes', 'townships'));
    }

    public function crear_guardar(CreateFormRequest $request)
    {
        if ($request->tipo_zona == 'Comuna') {
            $location = [
                'commune_id' => $request->commune_id,
                'quarter_id' => $request->quarter_id
            ];
        } else {
            $location = [
                'township_id' => $request->township_id,
                'sidewalk_id' => $request->sidewalk_id
            ];
        }

        $formulario = new Formulario();
        $formulario->propietario_id = $request->creador_id;
        $formulario->nombre = $request->nombres;
        $formulario->apellido = $request->apellidos;
        $formulario->email = $request->email;
        $formulario->telefono = $request->telefono;
        $formulario->genero = $request->genero;
        $formulario->direccion = $request->direccion;
        $formulario->tipo_zona = $request->tipo_zona;
        $formulario->location = json_encode($location);
        /* $formulario->zona = $request->zona; */
        $formulario->puesto_votacion = $request->puesto_votacion;
        $formulario->mensaje = $request->mensaje;
        $formulario->save();

        Alert::success('Formulario', 'Se ha creado el formulario con exito!');
        return redirect()->route('formularios');
    }

    public function actualizar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if (!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;

        $communes = Commune::select('id', 'name')->get();
        $townships = Township::select('id', 'name')->get();
        $location = json_decode($formulario->location);

        if ($formulario->tipo_zona == 'Comuna') {
            $locations_2 = Quarter::select('id', 'name')->where('commune_id', $location->commune_id)->get();
        } else {
            $locations_2 = Sidewalk::select('id', 'name')->where('township_id', $location->township_id)->get();
        }

        return view('formulario.actualizar', compact('formulario', 'communes', 'townships', 'location', 'locations_2'));
    }

    public function actualizar_guardar(UpdateFormRequest $request, $id)
    {

        $formulario = Formulario::find($id);
        if (!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        if ($request->tipo_zona == 'Comuna') {
            $location = [
                'commune_id' => $request->commune_id,
                'quarter_id' => $request->quarter_id
            ];
        } else {
            $location = [
                'township_id' => $request->township_id,
                'sidewalk_id' => $request->sidewalk_id
            ];
        }

        $formulario->propietario_id = $request->creador_id;
        $formulario->nombre = $request->nombres;
        $formulario->apellido = $request->apellidos;
        $formulario->email = $request->email;
        $formulario->telefono = $request->telefono;
        $formulario->genero = $request->genero;
        $formulario->direccion = $request->direccion;
        /* $formulario->zona = $request->zona; */
        $formulario->tipo_zona = $request->tipo_zona;
        $formulario->location = json_encode($location);
        $formulario->puesto_votacion = $request->puesto_votacion;
        $formulario->mensaje = $request->mensaje;
        $formulario->save();

        Alert::success('Formulario', 'Se ha actualizado el formulario con exito!');
        return redirect()->route('formularios');
    }

    public function ver(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if (!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;
        return view('formulario.ver', compact('formulario'));
    }

    public function eliminar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if (!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->propietario_nombre = User::find($formulario->propietario_id)->name;
        return view('formulario.eliminar', compact('formulario'));
    }

    public function eliminar_confirmar(Request $request, $id)
    {
        $formulario = Formulario::find($id);
        if (!$formulario) {
            Alert::error('Formulario', 'No se ha encontrado el formulario solicitado.');
            return redirect()->route('formularios');
        }

        $formulario->delete();

        Alert::success('Formulario', 'Se ha eliminado el formulario con exito.');
        return redirect()->route('formularios');
    }
}
