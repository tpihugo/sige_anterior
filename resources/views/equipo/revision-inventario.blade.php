@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())
            <div class="row">

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <hr>
                <h2>Revisión Inventario</h2>

                <form action="{{ route('equipo-encontrado') }}" method="post" enctype="multipart/form-data" class="col-md-12">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                Debe de llenar todos los campos
                            </ul>
                        </div>
                    @endif
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8 col-xs-12">
                            <label for="id">IDUdeG, Serial o Núm. SIGE</label>
                            <input type="text" class="form-control" id="id" name="id" value="{{old('id')}}">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <button type="submit" class="btn btn-success">Siguiente -></button>
                        </div>

                    </div>
                    <br>




                </form>
                <br>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8 col-xs-12">
                           {{-- <p><a href="{{ route('inventario-por-area', $area_id) }}" class="btn btn-primary">Detalle</a></p>--}}
                        </div>
                    </div>
            </div>
            <div class="row">
                <br>
                <hr>
                <p>CTA.</p>

            </div>
        @endif
    </div>
@endsection
