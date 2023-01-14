@extends('layouts.base')

@section('titulo')
    Eliminar usuario
@endsection

@section('cabecera')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Eliminar usuario</h1>
    </div>
@endsection

@section('cuerpo')
    <div class="container">
        <div class="row g-5">
            <div class="col-3"></div>
            <div class="col-7">
                <div class="row g-3">

                    <div class="col-sm-12">
                        <label for="nombres" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" value="{{ $usuario->name }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $usuario->email }}" readonly>
                    </div>

                    <div class="col-12">
                        <label for="telefono" class="form-label">Rol</label>
                        <input type="text" class="form-control" value="{{ $usuario->rol }}" readonly>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('usuarios') }}" class="btn btn-secondary">Cancelar</a>
                    <a href="{{ route('usuarios.eliminar.confirmar', $usuario->id) }}" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
        </main>
    @endsection
