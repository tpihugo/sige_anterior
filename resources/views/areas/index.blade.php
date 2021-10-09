@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role == 'admin')

    <div class="container">
        <div class="row">
		<div class="col-12">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
 @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
	</div>
    </div>
<div class="row">
		<div class="col-12">

            <h2>Listado de Áreas </h2>
            <br>
                <p align="right">
                    <a href="{{ route('areas.create') }}" class="btn btn-success">Capturar Área</a>
                    <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                </p>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Id Área</th>
                    <th>Tipo de Espacio</th>
                    <th>Sede</th>
                    <th>Edificio</th>
                    <th>Piso</th>
                    <th>División</th>
                    <th>Coordinación</th>
                    <th>Área</th>
                    <th>Acciones</th>


                </tr>
                </thead>
                <tbody>

                @foreach($areas as $area)
                    <tr>
                        <td>{{$area->id}}</td>
                        <td>{{$area->tipo_espacio}}</td>
                        <td>{{$area->sede}}</td>
                        <td>{{$area->edificio}}</td>
                        <td>{{$area->piso}}</td>
                        <td>{{$area->division}}</td>
                        <td>{{$area->coordinacion}}</td>
                        <td>{{$area->area}}</td>
                        <td><p><a href="{{ route('areas.edit', $area->id) }}" class="btn btn-outline-success">Editar</a></p>
                        <p>
                            <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                            <a href="#eliminar{{$area->id}}" role="button" class="btn btn-outline-danger" data-toggle="modal">Eliminar</a>
                        </p>
                            <!-- Modal / Ventana / Overlay en HTML -->
                            <div id="eliminar{{$area->id}}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h5>X</h5></button>

                                        </div>
                                        <div class="modal-body">
                                            <h5>¿Seguro de Eliminar esta área?</h5>
                                            <p class="text-primary"><small>{{$area->coordinacion}}. {{$area->area}}</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                                            <a href="{{ route('delete-area', $area->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div></td>

                    </tr>
                @endforeach
                </tbody>

            </table>
 </div>
        </div>
        <p>
            <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
        </p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script>

    </script>
    <script>
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "portugues-pre": function ( data ) {
                var a = 'a';
                var e = 'e';
                var i = 'i';
                var o = 'o';
                var u = 'u';
                var c = 'c';
                var special_letters = {
                    "Á": a, "á": a, "Ã": a, "ã": a, "À": a, "à": a,
                    "É": e, "é": e, "Ê": e, "ê": e,
                    "Í": i, "í": i, "Î": i, "î": i,
                    "Ó": o, "ó": o, "Õ": o, "õ": o, "Ô": o, "ô": o,
                    "Ú": u, "ú": u, "Ü": u, "ü": u,
                    "ç": c, "Ç": c
                };
                for (var val in special_letters)
                    data = data.split(val).join(special_letters[val]).toLowerCase();
                return data;
            },
            "portugues-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "portugues-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        } );
//"columnDefs": [{ type: 'portugues', targets: "_all" }],

        $(document).ready(function() {
            $('#example').DataTable( {

                "order": [[ 0, "asc" ]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel',
                    {
                        extend:'pdfHtml5',
                        orientation: 'landscape',
                        pageSize:'LETTER',
                    }

                ]
            } );
        } );
    </script>
@else
    Acceso No válido
@endif
@endsection
