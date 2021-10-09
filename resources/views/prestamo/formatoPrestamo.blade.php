<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Préstamo / Traslado de Equipos. SIGE</title>

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<style>
    .pie{
        font-size: 10px;
        text-align: right;
    }
    td {
	font-size: 12px;
	}
</style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <p class="text-center"><img class="img-responsive" src="images/logo.jpg" width="100%"></p>


        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
    <table class="table table-bordered" >
        <thead class="thead-light">
        <tr>
            <th scope="col" colspan="2"><h5>Formato de Prestamo / Traslado</h5></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Folio:</b> {{$prestamo->id}}</td>
                <td><b>Fecha: </b> {{$prestamo->fecha_inicio}}</td>
            </tr>
            <tr>
                <td><b>Tipo:</b> {{$prestamo->estado}}</td>
                <td><b>Solicitante: </b> {{$prestamo->solicitante}}</td>
            </tr>
            <tr>
                <td><b>Contacto: </b> {{$prestamo->contacto}}</td>
                <td><b>Cargo: </b> {{$prestamo->cargo}}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Lugar:</b> {{$prestamo->lugar}}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Equipos:</b> {{$prestamo->lista_equipos}}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Observaciones:</b> {{$prestamo->observaciones}}</td>
            </tr>
        </tbody>
    </table>
            <br>
            <br>
    <table class="table table-bordered" >

        <tbody>
            <tr>
                <td align="center"><b>Entrega</b></td>
                <td align="center"><b>Recibe</b></td>
            </tr>
            <tr>
                <td align="center"><b>Nombre</b></td>
                <td align="center"><b>Nombre</b></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td align="center"><b>Firma:</b></td>
                <td align="center"><b>Firma:</b></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
        </tbody>
    </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <br>
            <br>

            <p class="pie">Hora y día de Impresión:  {{ date('d-m-Y H:i:s') }}<br>
                Realizado por:  {{ Auth::user()->name }}<br>
                Formato CTA-010. Actualización: 28/abril/2021</p>
        </div>
    </div>
</div>
</body>
</html>
