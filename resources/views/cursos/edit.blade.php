@extends('layouts.app')
@section('content')

    <div class="container">
        @if (Auth::check() && Auth::user()->role == 'admin')
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Actualizar Curso</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('cursos.update', $curso->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        <div class="col">
                            {!! csrf_field() !!}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="tipo">Tipo </label>
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option selected value="{{ $curso->tipo }}">{{ $curso->tipo }}</option>
                                        <option disabled>Seleccione un tipo</option>
                                        <option value="Aula">Aula</option>
                                        <option value="Laboratorio" selected>Laboratorio</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="dia">Día </label>
                                    <select class="form-control" id="dia" name="dia">
                                        <option selected value="{{ $curso->dia }}">{{ $curso->dia }}</option>
                                        <option disabled>Elegir</option>
                                        <option value="Lunes" selected>Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="Miércoles">Miércoles</option>
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                        <option value="Sábado">Sábado</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="ciclo">Ciclo </label>
                                    <input type="text" class="form-control" id="ciclo" name="ciclo"
                                        value="{{ $curso->ciclo }}" max="6">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="font-weight-bold" for="id_area">Aula</label>
                                    <select class="form-control" class="form-control" id="js-example-basic-single"
                                        name="id_area">
                                        <option value="{{ $curso->id_area }}" selected>{{ $curso->aula }}</option>
                                        <option value="Elegir">Elegir</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->sede }} -
                                                {{ $area->division }} -
                                                {{ $area->coordinacion }} - {{ $area->area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="horario">Horario </label>
                                    <input type="text" class="form-control" id="horario" name="horario"
                                        value="{{ $curso->horario }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="crn">Crn </label>
                                    <input type="text" class="form-control" id="crn" name="crn"
                                        value="{{ $curso->crn }}">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="curso">Curso </label>
                                    <input type="text" class="form-control" id="curso" name="curso"
                                        value="{{ $curso->curso }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="codigo">Código </label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        value="{{ $curso->codigo }}" max="20">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="profesor">Profesor </label>
                                    <input type="text" class="form-control" id="profesor" name="profesor"
                                        value="{{ $curso->profesor }}">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="cupo">Cupo </label>
                                    <input type="number" class="form-control" id="cupo" name="cupo"
                                        value="{{ $curso->cupo }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="alumnos">Alumnos </label>
                                    <input type="number" class="form-control" id="alumnos" name="alumnos"
                                        value="{{ $curso->alumnos }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="pe">Pe </label>
                                    <input type="text" class="form-control" id="pe" name="pe" value="{{ $curso->pe }}"
                                        max="20">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="departamento">Departamento </label>
                                    <input type="text" class="form-control" id="departamento" name="departamento"
                                        value="{{ $curso->departamento }}">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="observaciones">Observaciones </label>
                                    <input type="text" class="form-control" id="observaciones" name="observaciones"
                                        value="{{ $curso->observaciones }}">
                                </div>
                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="row align-items-center m-0">
                            <div class="col-md-6">
                                <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">
                                    Guardar datos <i class="ml-1 fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row align-items-center">
                <br>
                <div class="col-12 ml-3">
                    <h5>En caso de inconsistencias, favor de reportarlas.</h5>
                </div>
                <hr>
            </div>
    </div>

@else
    El periodo de Registro de Proyectos a terminado
    @endif


@endsection
