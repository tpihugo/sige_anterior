@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Captura de Equipos</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });

                </script>

            </div>
            <form action="{{route('equipos.store')}}" method="post" enctype="multipart/form-data" class="col-12">
                <div class="row">
                    <div class="col">
                        {!! csrf_field() !!}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    Debe de llenar los campos marcados con un asterisco (*).
                                </ul>
                            </div>
                        @endif
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label for="udg_id">Id UdeG</label>
                                <input type="text" class="form-control" id="udg_id" name="udg_id" value="{{old('udg_id')}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="tipo_equipo">Tipo de Equipo </label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo">
                                    <option disabled selected>Elegir</option>
                                    @foreach($tipo_equipos as $tipos)
					<option value="{{$tipos->tipo_equipo}}">{{$tipos->tipo_equipo}}</option>
				    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="id_resguardante">Resguardante</label>
                                <select class="form-control" id="id_resguardante" name="id_resguardante">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($empleados as $empleado)
                                        <option value="{{$empleado->id}}">{{$empleado->nombre}} {{$empleado->codigo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label for="marca">Marca </label>
                                <input type="text" class="form-control" id="marca" name="marca" value="{{old('marca')}}" >
                            </div>

                            <div class="col-md-4">
                                <label for="modelo">Modelo </label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="{{old('modelo')}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="numero_serie">Número de Serie </label>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{old('numero_serie')}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label for="mac">MAC </label>
                                <input type="text" class="form-control" id="mac" name="mac" value="No aplica/No Especificado" >
                            </div>
                            <div class="col-md-4">
                                <label for="ip">IP </label>
                                <input type="text" class="form-control" id="ip" name="ip" value="No aplica/No Especificado" >
                            </div>
                            <div class="col-md-4">
                                <label for="tipo_conexion">Tipo de Conexión</label>
                                <select class="form-control" id="tipo_conexion" name="tipo_conexion">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    <option value="Red Cableada">Red Cableada</option>
                                    <option value="Solo Wifi<">Solo Wifi</option>
                                    <option value="Wifi y Ethernet">Wifi y Ethernet</option>
                                    <option value="Sin conexión">Sin conexión</option>
                                </select>
                            </div>
                        </div>
			<br>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="resguardante">Resguardante</label>
                                <select name="resguardante" id="resguardante" class="form-control">
				    <option disable selected>Elegir</option>
                                    <option value="Otra dependencia">Otra dependencia</option>
                                    <option value="CTA">CTA</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="localizado_sici">Inventariable</label>
                                <select name="localizado_sici" id="localizado_sici" class="form-control">
				    <option disable selected>Elegir</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <label for="detalles">Detalles</label>
                                <textarea class="form-control" id="detalles" name="detalles">{{old('detalles')}}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <label for="area_id">Areas</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single" name="id_area">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
			<div class="row align-items-center">
                    		<div class="col-md-6">
                        		<a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                        		<button type="submit" class="btn btn-success">Guardar datos</button>
                    		</div>
                    	</div>
               	 	</div>
                	<br>
                	
            	</div>
            </form>
            <br>
            <div class="row align-items-center">

                <br>
                <h5>En caso de inconsistencias enviar un correo a victor.ramirez@academicos.udg.mx</h5>
                <hr>

            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif

@endsection
