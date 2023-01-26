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
                            @error('creador')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="nombres" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder=""
                                value="" required>
                            @error('nombres')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="apellidos" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder=""
                                value="" required>
                            @error('apellidos')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="usuario@mail.com" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                placeholder="+57 321-123-1122" required>
                            @error('telefono')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="genero" class="form-label">Sexo</label>
                                <select name="genero" id="genero" class="form-control" required>
                                    <option value="">Selecciona genero</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            @error('genero')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                placeholder="Direccion" required>
                            @error('direccion')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="tipo_zona" class="form-label">Tipo de ubicacion</label>
                            <select name="tipo_zona" id="tipo_zona" class="form-control" required>
                                <option value="">Seleccion el tipo de zona</option>
                                <option value="Comuna">Comuna</option>
                                <option value="Vereda">Vereda</option>
                            </select>
                            @error('tipo_zona')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12" id="zona-container">
                            <select name="commune_id" id="commune_id" style="display: none" class="form-control mb-2">
                                <option value="">Selecciona una comuna</option>
                                @foreach ($communes as $commune)
                                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                                @endforeach
                            </select>

                            <select name="township_id" id="township_id" style="display: none" class="form-control mb-2">
                                <option value="">Selecciona una vereda</option>
                                @foreach ($townships as $township)
                                    <option value="{{ $township->id }}">{{ $township->name }}</option>
                                @endforeach
                            </select>

                            @error('commune_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('township_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12" id="zona-container">
                            <select name="quarter_id" id="quarter_id" style="display: none" class="form-control mb-2">
                            </select>

                            <select name="sidewalk_id" id="sidewalk_id" style="display: none" class="form-control mb-2">
                            </select>

                            @error('quarter_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('sidewalk_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- <div class="col-12">
                            <label for="zona" class="form-label">Comuna / Corregimiento</label>
                            <input type="text" class="form-control" id="zona" name="zona" placeholder="Comuna"
                                required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu Comuna / Corregimiento.
                            </div>
                        </div> --}}

                        <div class="col-12">
                            <label for="zona" class="form-label">Puesto de votacion</label>
                            <input type="text" class="form-control" id="puesto_votacion" name="puesto_votacion"
                                placeholder="Puesto de votacion" required>
                            <div class="invalid-feedback">
                                Por favor ingresa tu puesto de votacion.
                            </div>

                            @error('puesto_votacion')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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

        <script>
            const selectTipoZona = document.getElementById('tipo_zona');
            let commune=document.getElementById('commune_id');
            let township=document.getElementById('township_id');
            let quarter=document.getElementById('quarter_id');
            let sidewalk=document.getElementById('sidewalk_id');
            selectTipoZona.addEventListener('change', (e) => {
                if (e.target.value == 'Comuna') {
                    commune.style.display = 'block';
                    commune.required = true;
                    /* set value towship to 0 */
                    township.value = '';
                    township.style.display = 'none';
                    township.required = false;
                    /* set value sidewalk to 0 */
                    sidewalk.value = '';
                    sidewalk.style.display = 'none';
                    sidewalk.required = false;

                    commune.addEventListener('change', (a)=>{
                        let id = a.target.value

                        let routeLocationQuarters = `{{ route('location.quarters', ':id') }}`;
                        url = routeLocationQuarters.replace(':id', id);

                        fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            let html = '';
                            html += `<option value="">Seleccione un barrio</option>`
                            data.forEach(quarter => {
                                html += `<option value="${quarter.id}">${quarter.name}</option>`
                            });
                            quarter.innerHTML = html;
                            quarter.style.display = 'block';
                            quarter.required = true;
                        })
                    })

                }else if(e.target.value == 'Vereda'){
                    township.style.display = 'block';
                    commune.style.display = 'none';
                    commune.required = false;
                    quarter.style.display = 'none';
                    quarter.required = false;

                    township.addEventListener('change', (a)=>{
                        let id = a.target.value

                        let routeLocationSidewalks = `{{ route('location.sidewalks', ':id') }}`;
                        url = routeLocationSidewalks.replace(':id', id);

                        fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            let html = '';
                            html += `<option value="">Seleccione una vereda</option>`
                            data.forEach(sidewalk => {
                                html += `<option value="${sidewalk.id}">${sidewalk.name}</option>`
                            });
                            sidewalk.innerHTML = html;
                            sidewalk.style.display = 'block';
                            sidewalk.required = true;
                        })
                    })
                }else {
                    commune.style.display = 'none';
                    commune.required = false;
                    township.style.display = 'none';
                    township.required = false;
                    quarter.style.display = 'none';
                    quarter.required = false;
                    sidewalk.style.display = 'none';
                    sidewalk.required = false;
                }
            });
        </script>
        <script src="{{asset('js/quarters.js')}}"></script>
        <script src="{{asset('js/sidewalks.js')}}"></script>

@endsection
