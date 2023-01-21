@extends('layouts.base')

@section('titulo')
Actualizar formulario
@endsection

@section('css-extra')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
    rel="stylesheet" />
@endsection

@section('cabecera')
<div class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Actualizar formulario</h1>
</div>
@endsection

@section('cuerpo')
<div class="container">
    <div class="row g-5">
        <div class="col-3"></div>
        <div class="col-7">
            <form class="needs-validation" method="POST"
                action="{{ route('formularios.actualizar.guardar', $formulario->id) }}" novalidate>
                @csrf
                <input type="hidden" name="creador_id" id="creador_id" value="{{ $formulario->propietario_id }}">

                <div class="row g-3">
                    <div class="col-12">
                        <label for="creador" class="form-label">Quien lo diligencia</label>
                        <select class="form-control" name="creador" id="creador" required>
                            <option value="{{ $formulario->propietario_id }}">{{ $formulario->propietario_nombre }}
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombres" class="form-label">Nombre(s)</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder=""
                            value="{{ $formulario->nombre }}" required>
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="apellidos" class="form-label">Apellido(s)</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder=""
                            value="{{ $formulario->apellido }}" required>
                        <div class="invalid-feedback">
                            Este campo es requerido.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@mail.com"
                            value="{{ $formulario->email }}" required>
                        <div class="invalid-feedback">
                            Por favor ingresa un Email valido.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"
                            placeholder="+57 321-123-1122" value="{{ $formulario->telefono }}" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu numero telefonico.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="genero" class="form-label">Sexo</label>
                        <input type="text" class="form-control" id="genero" name="genero"
                            placeholder="Hombre / Mujer / Otro" value="{{ $formulario->genero }}" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu sexo.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion"
                            value="{{ $formulario->direccion }}" required>
                        <div class="invalid-feedback ">
                            Por favor ingresa tu direccion.
                        </div>
                    </div>

                    {{-- <div class="col-12">
                        <label for="zona" class="form-label">Comuna / Corregimiento</label>
                        <input type="text" class="form-control" id="zona" name="zona" placeholder="Comuna"
                            value="{{ $formulario->zona }}" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu Comuna / Corregimiento.
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <label for="tipo_zona" class="form-label">Tipo de ubicacion</label>
                        <select name="tipo_zona" id="tipo_zona" class="form-control" required>
                            <option value="0">Seleccion el tipo de zona</option>
                            <option value="Comuna" @if ($formulario->tipo_zona == 'Comuna')
                                selected
                                @endif>Comuna</option>
                            <option value="Vereda" @if ($formulario->tipo_zona == 'Vereda')
                                selected
                                @endif>Vereda</option>
                        </select>
                        @error('tipo_zona')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12" id="zona-container">
                        <select name="commune_id" id="commune_id" class="form-control" @if ($formulario->tipo_zona
                            !='Comuna')
                            style="display: none"
                            @endif>
                            <option value="0">Selecciona una comuna</option>
                            @foreach ($communes as $commune)
                            <option value="{{ $commune->id }}" @if ($formulario->tipo_zona =='Comuna' &&
                                $location->commune_id == $commune->id)
                                selected
                                @endif>{{ $commune->name }}</option>
                            @endforeach
                        </select>

                        <select name="township_id" id="township_id" @if ($formulario->tipo_zona !='Vereda')
                            style="display: none"
                            @endif class="form-control" required>
                            <option value="0">Selecciona una vereda</option>
                            @foreach ($townships as $township)
                            <option value="{{ $township->id }}" @if ($formulario->tipo_zona =='Vereda' &&
                                $location->township_id == $township->id)
                                selected
                                @endif
                                >{{ $township->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('commune_id'))
                            @error('commune_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        @endif

                        @if ($errors->has('township_id'))
                            @error('township_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="col-12" id="zona-container">
                        <select name="quarter_id" id="quarter_id" class="form-control" @if ($formulario->tipo_zona
                            !='Comuna')
                            style="display: none"
                            @endif>
                            @if ($formulario->tipo_zona =='Comuna')
                            @foreach ($locations_2 as $location_2)
                            <option value="{{ $location_2->id }}" @if ($location->quarter_id == $location_2->id)
                                selected
                                @endif
                                >{{ $location_2->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        <select name="sidewalk_id" id="sidewalk_id" class="form-control" @if ($formulario->tipo_zona
                            !='Vereda')
                            style="display: none"
                            @endif>
                            @if ($formulario->tipo_zona =='Vereda')
                            @foreach ($locations_2 as $location_2)
                            <option value="{{ $location_2->id }}" @if ($location->sidewalk_id == $location_2->id)
                                selected
                                @endif
                                >{{ $location_2->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        @if ($errors->has('quarter_id'))
                            @error('quarter_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        @endif

                        @if ($errors->has('sidewalk_id'))
                            @error('sidewalk_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="zona" class="form-label">Puesto de votacion</label>
                        <input type="text" class="form-control" id="puesto_votacion" name="puesto_votacion"
                            placeholder="Puesto de votacion" value="{{ $formulario->puesto_votacion }}" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu puesto de votacion.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="mensaje" class="form-label">Mensaje <span
                                class="text-muted">(Opcional)</span></label>
                        <textarea class="form-control" name="mensaje" id="mensaje" cols="30"
                            rows="10">{{ $formulario->mensaje }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('formularios') }}" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-success" type="submit">Actualizar</button>
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
                $('#creador').val('{{ $formulario->propietario_id }}').trigger('change');

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
                                console.log('no valido');
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
                })()
            })
    </script>

    <script>
        const selectTipoZona = document.getElementById('tipo_zona');
        let commune=document.getElementById('commune_id');
        let township=document.getElementById('township_id');
        let quarter=document.getElementById('quarter_id');
        let sidewalk=document.getElementById('sidewalk_id');
        selectTipoZona.addEventListener('change', (e) => {
            if (e.target.value == 'Comuna') {
                commune.style.display = 'block';
                commune.classList.add('form-control');
                /* set value towship to 0 */
                township.value = 0;
                township.style.display = 'none';
                township.classList.remove('form-control');
                /* set value sidewalk to 0 */
                sidewalk.value = 0;
                sidewalk.style.display = 'none';
                sidewalk.classList.remove('form-control');

                commune.addEventListener('change', (a)=>{
                    let id = a.target.value

                    let routeLocationQuarters = `{{ route('location.quarters', ':id') }}`;
                    url = routeLocationQuarters.replace(':id', id);

                    fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        html += `<option value="0">Seleccione un barrio</option>`
                        data.forEach(quarter => {
                            html += `<option value="${quarter.id}">${quarter.name}</option>`
                        });
                        quarter.innerHTML = html;
                        quarter.style.display = 'block';
                        quarter.classList.add('form-control');
                    })
                })

            }else if(e.target.value == 'Vereda'){
                township.style.display = 'block';
                township.classList.add('form-control')
                commune.style.display = 'none';
                commune.classList.remove('form-control');
                quarter.style.display = 'none';
                quarter.classList.remove('form-control');

                township.addEventListener('change', (a)=>{
                    let id = a.target.value

                    let routeLocationSidewalks = `{{ route('location.sidewalks', ':id') }}`;
                    url = routeLocationSidewalks.replace(':id', id);

                    fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        html += `<option value="0">Seleccione una vereda</option>`
                        data.forEach(sidewalk => {
                            html += `<option value="${sidewalk.id}">${sidewalk.name}</option>`
                        });
                        sidewalk.innerHTML = html;
                        sidewalk.style.display = 'block';
                        sidewalk.classList.add('form-control');
                    })
                })
            }else {
                commune.style.display = 'none';
                commune.classList.remove('form-control');
                township.style.display = 'none';
                township.classList.remove('form-control');
                quarter.style.display = 'none';
                quarter.classList.remove('form-control');
                sidewalk.style.display = 'none';
                sidewalk.classList.remove('form-control');
            }
        });
    </script>
    @endsection
