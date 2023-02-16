@extends('layouts.base')

@section('titulo')
    Formularios
@endsection

@section('css-extra')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
        .textLeft{
            text-align: left;
        }
    </style>
@endsection

@section('cabecera')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Formularios</h1>
        <p class="fs-5 text-muted">Aqui podras encontrar la gestion de formularios, solo los administradores pueden crear,
            editar y eliminar formularios.</p>
    </div>

    @if (Auth::user()->hasRole(['administrador', 'simple']))
        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-2 mb-2 text-right">
                <button type="button" id="export-form" class="btn btn-warning">Exportar</button>
            </div>
            <div class="col-2 mb-2 text-right">
                <a href="{{ route('formularios.crear') }}" class="btn btn-success">Crear formulario</a>
            </div>
        </div>
    @endif
@endsection

@section('cuerpo')
    <div class="table-responsive">
        <table class="table text-center" id="tablas-formularios">
            <thead>
                <tr>
                    <th scope="col">Identificacion</th>
                    <th>Nombre completo</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Puesto votacion</th>
                    <th>Ubicacion</th>
                    <th>Accion</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js-extra')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        const route="{{Route('forms.all')}}"
        const exportForm ="{{Route('excel.forms')}}"
        $(document).ready(function (){
            /* consume the route and print the table with datatable */
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('#tablas-formularios').DataTable({
                        processing: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json',
                        },
                        "columnDefs":[
                            {
                                "targets": [0],
                                "visible": false,
                                "searchable": false
                            },
                            {
                                "targets": "_all",
                                "className": "textLeft"
                            },
                            /* width column 4 */
                            {
                                "targets": [4],
                                "width": "10%"
                            },
                            {
                                "targets": [6],
                                "width": "10%"
                            }
                        ],
                        data: data,
                        columns: [
                            {data: 'propietario_id'},
                            {data: 'nombre'},
                            {data: 'email'},
                            {data: 'telefono'},
                            {data: 'puesto_votacion'},
                            {data: 'location'},
                            {data: 'acciones'}
                        ]
                    })
                }
            })

            /* export the table to excel */
            function exportExcel(){
                window.location=exportForm
            }

            $('#export-form').click(function (){
                event.preventDefault()
                exportExcel()
            })
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#tablas-formularios').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json',
                },
                ajax: "{!! route('formularios.tabla') !!}",
                columns: [{
                        data: 'creador',
                        name: 'creador'
                    }, {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'telefono',
                        name: 'telefono'
                    },
                    {
                        data: 'puesto_votacion',
                        name: 'puesto_votacion'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'acciones',
                        name: 'acciones'
                    }
                ]
            });
        })
    </script> --}}
@endsection
