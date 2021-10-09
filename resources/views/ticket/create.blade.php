@extends('layouts.app')
@section('content')


    <div class="container">
        @if(Auth::check() && Auth::user()->role =='admin')
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Captura de Tickets</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });
                    n =  new Date();
                    //Año
                    y = n.getFullYear();
                    //Mes
                    m = n.getMonth() + 1;
                    //Día
                    d = n.getDate();

                    //Lo ordenas a gusto.
                    document.getElementById("date").innerHTML = d + "/" + m + "/" + y;
                </script>

            </div>

            <form action="{{route('tickets.store')}}" method="post" enctype="multipart/form-data" class="col-12">
                <div class="row">
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
                        <br>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="prioridad">Prioridad </label>
                                <select class="form-control" id="prioridad" name="prioridad">
                                    <option disabled >Elegir</option>
                                    <option value="Alta" >Alta</option>
                                    <option value="Media" selected>Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="estatus">Estatus </label>
                                <select class="form-control" id="estatus" name="estatus">
                                    <option disabled >Elegir</option>
                                    <option value="Abierto" selected>Abierto</option>
                                    <option value="Cerrado">Cerrado</option>
                                    <option value="En Espera">En Espera</option>
                                    <option value="Escalado">Escalado</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="categoria">Categoría </label>
                                <select class="form-control" id="categoria" name="categoria">
                                    <option disabled >Elegir</option>
                                    <option value="Incidente" selected>Incidente</option>
                                    <option value="Solicitudes de Servicio">Solicitudes de Servicio</option>
				    <option value="Reporte de aula">Reporte de aula</option>

                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="area_id">Areas</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single" name="area_id" required>
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tecnico_id">Técnico </label>
                                <select class="form-control" id="tecnico_id" name="tecnico_id" required>
                                    <option disabled >Elegir</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{$tecnico->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <label for="solicitante">Solicitante</label>
                                <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{old('solicitante')}}" required >
                            </div>
                            <div class="col-md-4">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto" value="{{old('contacto')}}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_reporte">Fecha Reporte </label>

                                <input type="date" class="form-control" id="fecha_reporte" name="fecha_reporte" required>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                                <label for="datos_reporte">Reporte</label>
                                <textarea class="form-control" id="datos_reporte" name="datos_reporte">{{old('datos_reporte')}}</textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="datos_reporte"><h5>Solo llenar esta sección cuando el ticket se haya terminado</h5></label>

                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="fecha_inicio">Fecha Inicio </label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{old('fecha_inicio')}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_termino">Fecha Termino </label>
                                <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{old('fecha_termino')}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="problema">Categoría Problema </label>
                                <select class="form-control" id="problema" name="problema">
                                    <option disabled >Elegir</option>
                                    <option value="Falla en Hardware" selected>Falla en Hardware</option>
                                    <option value="Software">Software</option>
                                    <option value="Capacitación">Capacitación</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="solucion">Solucion</label>
                                <textarea class="form-control" id="solucion" name="solucion">{{old('solucion')}}</textarea>
                            </div>
                        </div>
                        </div>
                        <br>

                    </div>
                    <br>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            Guardar datos
                            <i class="ml-1 fas fa-save"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <h5>En caso de inconsistencias, favor de reportarlas.</h5>
                <hr>

            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif


@endsection
