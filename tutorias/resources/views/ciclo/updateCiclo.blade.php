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
                <h2>Editar ciclo</h2>
                <hr>
                <p>* Campos Obligatorios</p>
            </div>
            <form action="{{ route('updated-ciclo') }}" method="post" enctype="multipart/form-data" class="col-md-12">
                <div class="row">
                    <div class="col">
                        {!! csrf_field() !!}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    Debe de llenar los campos marcados con un asterisco (*) o el formulario y su información ya se registró.
                                </ul>
                            </div>
                        @endif

                        <div class="col">
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="id">Id</label>
                                <input type="text" class="form-control" id="id" name="id" value="{{$ciclo->id}}" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="nombre">Nombre del nuevo ciclo *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{$ciclo->nombre}}" >
                                <label>Ejemplo: 2020A, 2020B</label>
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="fecha_inicio">Fecha de inicio del ciclo *</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{$ciclo->fecha_inicio}}" >
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="fecha_fin">Fecha fin del ciclo *</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{$ciclo->fecha_fin}}" >
                            </div>
                        </div>
                        <div></div>
                        <div class="col">
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="registro_activo">Inscripción activa *</label>
                                <select class="form-control" id="registro_activo" name="registro_activo">
                                    @if($ciclo->registro_activo == '0')
                                        <option value="{{$ciclo->registro_activo}}" selected>No</option>
                                        <option value="1">Si</option>
                                    @elseif($ciclo->registro_activo == '1')
                                        <option value="{{$ciclo->registro_activo}}" selected>Si</option>
                                        <option value="0">No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="registro_activo">Ciclo actual *</label>
                                <select class="form-control" id="activo" name="activo">
                                    @if($ciclo->activo == 1)
                                        <option value="{{$ciclo->activo}}" selected>Si</option>
                                        <option value="0">No</option>
                                    @elseif($ciclo->activo == 0)
                                        <option value="{{$ciclo->activo}}" selected>No</option>
                                        <option value="1">Si</option>
                                    @endif
                                </select>
                                <label>Seleccione la opción "Si" si el ciclo a actualizar es el ciclo actual.</label>
                            </div>
                            <div class="form-group col-md-12 col-xs-12">
                                <label for="leyenda">Leyenda *</label>
                                <p>La leyenda se podrá visualizar cuando el registro a tutorías no se encuentre activo.</p>
                                <input type="text" class="form-control" id="leyenda" name="leyenda" value="{{$ciclo->leyenda}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{ route('ciclos') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar datos</button>
                    </div>
                </div>
            </form>
            <div class="row"></div>{{--Div para acomodo de la página--}}
            <div class="row">
                <br>
                <h3>En caso de tener alguna duda, contactar al Programa de Tutorías en el correo electrónico: coordinacion.lri.udg@gmail.com</h3>
                <hr>
                <p>LICENCIATURA EN RELACIONES INTERNACIONALES</p>
                <p>CUCSH</p>
                <p>Belenes</p>



            </div>
    </div>

    @else
        El periodo de inscripciones se ha terminado
    @endif

@endsection
