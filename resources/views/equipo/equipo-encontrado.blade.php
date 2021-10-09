@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <h2>Listado de Equipo Encontrado</h2>

        </div>
        <div class="row">
            <div class="table-responsive-sm">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">IdEquipo</th>
                        <th scope="col">IDUdeG</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Núm. Serie</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($listadoEquipos as $listadoEquipo)
                        <tr>
                            <th scope="row">{{$listadoEquipo->id }}</th>
                            <td>{{ $listadoEquipo->udg_id }}</td>
                            <td>{{ $listadoEquipo->tipo_equipo}} - {{ $listadoEquipo->marca }} - {{ $listadoEquipo->modelo }}</td>
                            <td>{{ $listadoEquipo->numero_serie }}</td>
                            <td>{{ $listadoEquipo->detalles }}<br> {{ $listadoEquipo->resguardante }} <br> {{ $listadoEquipo->localizado_sici }}</td>
                            <td>{{ $listadoEquipo->area }}</td>
                            <td><p><a class="btn btn-success" href="{{ route('registro-inventario', ['equipo_id' => $listadoEquipo->id, 'revisor_id' => Auth::user()->id, 'inventario' => '2021A', 'origen'=>'express']) }}" >Registrar Equipo</a></p>
                            <p><a href="{{ route('cambiar-ubicacion', ['equipo_id' => $listadoEquipo->id, 'tipo' => 'inventario']) }}" class="btn btn-primary">Cambiar Ubicación</a></p></td>
                            <td><!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#eliminar{{$listadoEquipo->id}}" role="button" class="btn btn-danger" data-toggle="modal">Agregar Nota</a>

                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="eliminar{{$listadoEquipo->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{route('inventario.store')}}" method="POST">
                                                {!! csrf_field() !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Cerrar</button>

                                            </div>
                                            <div class="modal-body">

                                                <h4>Agregar Nota al Bien</h4>

                                                <div class="row g-3 align-items-center">
                                                    <div class="col-md-12">

                                                        <input type="text" class="form-control" id="equipo_id" name="equipo_id" value="{{$listadoEquipo->id}}" >
                                                        <input type="text" class="form-control" id="area_id" name="area_id" value="{{$listadoEquipo->id_area}}" >
                                                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}" >
                                                        <textarea class="form-control" id="nota" name="nota">{{old('nota')}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                {{--{{ route('delete-alumno',['alumno_id' => $listaTutor->id]) }} --}}
                                                <button type="submit" class="btn btn-danger">Guardar Nota</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div></td>

                   </tr>
               @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
