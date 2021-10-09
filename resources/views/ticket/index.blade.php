@extends('layouts.app')

@section('content')
    @if(Auth::check() && Auth::user()->role =='admin')

    <div class="container-fluid">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <h2>Tickets </h2>
                    <p align="right">
                        <a href="{{ route('tickets.create') }}" class="btn btn-success">Capturar Ticket</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                    </p>
            </div>
        </div>
        <br>
        <form action="{{route('filtroTickets')}}" method="post" enctype="multipart/form-data" class="col-12">
            <div class="row g-3 align-items-center">
                <div class="col">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <br>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tecnico_id">Técnico </label>
                    <select class="form-control" id="tecnico_id" name="tecnico_id">
                        @if(isset($tecnicoElegido->id) && !is_null($tecnicoElegido->id))
                            <option value="{{$tecnicoElegido->id}}" selected>{{$tecnicoElegido->nombre}}</option>
                            <option disabled >Elegir</option>
                        @else
                            <option disabled selected>Elegir</option>
                        @endif

                        @foreach($tecnicos as $tecnico)
                            <option value="{{$tecnico->id}}">{{$tecnico->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="estatus">Estatus </label>
                    <select class="form-control" id="estatus" name="estatus">
                        @if(isset($estatus) && !is_null($estatus))
                            <option value="{{$estatus}}">{{$estatus}}</option>
                            <option disabled >Elegir</option>
                        @else
                            <option disabled selected>Elegir</option>
                        @endif
                        <option value="Abierto">Abierto</option>
                        <option value="Cerrado">Cerrado</option>
                        <option value="Escalado">Escalado</option>
                    </select>

                </div>
                <div class="col-md-2 " >
                    <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-success">Quitar Filtro</a>
                </div>
            </div>
            <br>

    </form>
        <div class="row g-3 align-items-center">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Folio</th>
                    <th>Estatus</th>
                    <th>Fecha Reporte</th>
                    <th>Área</th>
                    <th>Solicitante</th>
                    <th>Contacto</th>
                    <th>Técnico</th>
                    <th>Categoría y Prioridad</th>
                    <th>Reporte</th>
                    <th>Solución y cierre</th>
                    <th>Acciones</th>

                </tr>
                </thead>
                <tbody>

                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{$ticket->id}}</td>
                        <td>{{$ticket->estatus}}</td>
                        <td>{{ \Carbon\Carbon::parse($ticket->fecha_reporte)->format('d/m/Y') }}</td>
                        <td>{{$ticket->area}}</td>
                        <td>{{$ticket->solicitante}}</td>
                        <td>{{$ticket->contacto}}</td>
                        <td>{{$ticket->tecnico}}</td>
                        <td>{{$ticket->categoria}}. Prioridad: {{$ticket->prioridad}}</td>
                        <td>{{$ticket->datos_reporte}}</td>
                        @if(is_null($ticket->fecha_termino))
                            <td>En proceso de Realización</td>
                        @else
                        <td>Inicio: {{\Carbon\Carbon::parse($ticket->fecha_inicio)->format('d/m/Y') }}. Fin: {{\Carbon\Carbon::parse($ticket->fecha_termino)->format('d/m/Y')}}. Problema: {{$ticket->problema}}.
                            Solución: {{$ticket->solucion}}</td>
                        @endif
                        <td><p><a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-outline-success">Editar</a></p>
                        <p><a href="{{ route('recepcionEquipo', $ticket->id) }}" class="btn btn-outline-primary">Recibo de equipo</a></p>
                        <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                            <a href="#eliminar{{$ticket->id}}" role="button" class="btn btn-outline-danger" data-toggle="modal">Eliminar</a>

                            <!-- Modal / Ventana / Overlay en HTML -->
                            <div id="eliminar{{$ticket->id}}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h5>X</h5></button>

                                        </div>
                                        <div class="modal-body">
                                            <h5>¿Seguro de Eliminar este Ticket?</h5>
                                            <p class="text-primary"><small>{{$ticket->solicitante}}. {{$ticket->datos_reporte}} </small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                                            <a href="{{ route('delete-ticket', $ticket->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div></td>

                    </tr>
                @endforeach
                </tbody>

            </table>

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
                "pageLength":100,
                "order": [[ 0, "desc" ]],
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
