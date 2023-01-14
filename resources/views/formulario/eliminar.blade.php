@extends('layouts.base')

@section('titulo')
    Eliminar formulario
@endsection

@section('cabecera')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Eliminar formulario</h1>
    </div>
@endsection

@section('cuerpo')
    <div class="container">
        <div class="row g-5">
            <div class="col-3"></div>
            <div class="col-7">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="creador" class="form-label">Quien lo diligencia</label>
                        <input type="text" class="form-control" value="{{ $formulario->propietario_nombre }}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombres" class="form-label">Nombre(s)</label>
                        <input type="text" class="form-control" value="{{ $formulario->nombre }}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="apellidos" class="form-label">Apellido(s)</label>
                        <input type="text" class="form-control" value="{{ $formulario->apellido }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $formulario->email }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" value="{{ $formulario->telefono }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="genero" class="form-label">Sexo</label>
                        <input type="text" class="form-control" value="{{ $formulario->genero }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" value="{{ $formulario->direccion }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="zona" class="form-label">Comuna / Corregimiento</label>
                        <input type="text" class="form-control" value="{{ $formulario->zona }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="zona" class="form-label">Puesto de votacion</label>
                        <input type="text" class="form-control" value="{{ $formulario->puesto_votacion }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" cols="30" rows="10" readonly>{{ $formulario->mensaje }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('formularios') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('formularios.eliminar.confirmar', $formulario->id) }}" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
        </main>
    @endsection
