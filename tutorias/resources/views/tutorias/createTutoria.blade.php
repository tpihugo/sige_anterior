@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::user()->role == 'admin')
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Registro de Tutorías</h2>
                <hr>
                <p>* Campos Obligatorios</p>
                <form action="{{ route ('saveTutoria') }}" method="post" enctype="multipart/form-data" class="col-md-12">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                Debe de llenar los campos marcados con un asterisco (*)
                            </ul>
                        </div>
                    @endif
                    <div class="form-group col-md-3 col-xs-12">
                        <label for="IdTutor">Seleccionar Tutor *</label>
                        <select class="form-control" id="IdTutor" name="IdTutor">
                            @foreach($tutores as $tutor)
                                   <option value="{{ $tutor->id }}">{{ $tutor->nombre }} {{ $tutor->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-xs-12">
                        <label for="ciclo">Ciclo*</label>
                        <select class="form-control" id="ciclo" name="ciclo">
                            @foreach($ciclos as $ciclo)
                                <option value="{{$ciclo->nombre}}">{{$ciclo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-xs-12">
                        <label for="nombreTutoria">Nombre Tutoria *</label>
                        <input type="text" class="form-control" id="nombreTutoria" name="nombreTutoria" value="Tutoría Alumnos" >
                    </div>
                    <div class="form-group col-md-3 col-xs-12">
                        <label for="cupo">Cupo *</label>
                        <input type="text" class="form-control" id="cupo" name="cupo" value="{{old('cupo')}}" >
                    </div>
                    <button type="submit" class="btn btn-success">Guardar datos</button>

                </form>
            </div>
            <div class="row">

                <br>
                <h3>En caso de tener un problema con el registro contactar a su coordinación de carrera</h3>
                <hr>
                <p>CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES.</p>
                <p>Relaciones Públicas Internacionales</p>
                <p>Belenes</p>
            </div>
        @else
            Usuario no válido
        @endif
    </div>
@endsection
