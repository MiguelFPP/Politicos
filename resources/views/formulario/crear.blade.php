@extends('layouts.base')

@section('titulo')
    Crear formulario
@endsection

@section('css-extra')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        rel="stylesheet" />
@endsection

@section('cabecera')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Nuevo formulario</h1>
    </div>
@endsection

@section('cuerpo')
    <div class="container">
        <div class="row g-5">
            <div class="col-3"></div>
            <div class="col-7">
                <form class="needs-validation" method="POST" action="{{ route('formularios.crear.guardar') }}" novalidate>
                    @csrf
                    <input type="hidden" name="creador_id" id="creador_id"
                        @if (Auth::user()->hasRole('simple'))
                            value="{{ Auth::user()->id }}"
                        @endif>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="creador" class="form-label">Quien lo diligencia</label>
                            <select class="form-control" name="creador" id="creador" required
                                @if (Auth::user()->hasRole('simple'))
                                    disabled
                                @endif>
                                @if (Auth::user()->hasRole('simple'))
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                            <div class="invalid-feedback">
                                Este campo es requerido.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="nombres" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder=""
                                value="" required>
                            <div class="invalid-feedback">
                                Este campo es requerido.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="apellidos" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder=""
                                value="" required>
                            <div class="invalid-feedback">
                                Este campo es requerido.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="usuario@mail.com" required>
                            <div class="invalid-feedback">
                                Por favor ingresa un Email valido.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                placeholder="+57 321-123-1122" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu numero telefonico.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="genero" class="form-label">Sexo</label>
                                <select name="genero" id="genero" class="form-control" required>
                                    <option value="">Selecciona genero</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            <div class="invalid-feedback">
                                Por favor ingresa tu sexo.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                placeholder="Direccion" required>
                            <div class="invalid-feedback ">
                                Por favor ingresa tu direccion.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="tipo_zona" class="form-label">Tipo de ubicacion</label>
                            <select name="tipo_zona" id="tipo_zona" class="form-control" required>
                                <option value="0">Seleccion el tipo de zona</option>
                                <option value="Comuna">Comuna</option>
                                <option value="Vereda">Vereda</option>
                            </select>
                            <div class="invalid-feedback">
                                Seleccion un tipo de zona valido
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="zona" class="form-label">Comuna / Corregimiento</label>
                            <input type="text" class="form-control" id="zona" name="zona" placeholder="Comuna"
                                required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu Comuna / Corregimiento.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="zona" class="form-label">Puesto de votacion</label>
                            <input type="text" class="form-control" id="puesto_votacion" name="puesto_votacion"
                                placeholder="Puesto de votacion" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu puesto de votacion.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="mensaje" class="form-label">Mensaje <span
                                    class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control" name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('formularios') }}" class="btn btn-secondary">Cancelar</a>
                        <button class="btn btn-success" type="submit">Crear</button>
                    </div>
                </form>
            </div>
        </div>
        </main>
    @endsection

    @section('js-extra')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#creador').select2({
                    theme: "bootstrap",
                    ajax: {
                        dataType: 'json',
                        url: "{!! route('util.lista_usuarios') !!}",
                        type: "get",
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }

                });

                $('#creador').on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#creador_id').val(data.id);
                });

                (() => {
                    'use strict'

                    const forms = document.querySelectorAll('.needs-validation')
                    Array.from(forms).forEach(form => {
                        form.addEventListener('submit', event => {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
                })()
            })
        </script>
    @endsection
