<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Equipo;
use App\Models\Empleado;
use App\Models\VsEquipo;
use App\Models\VsPrestamo;
use App\Models\EquipoPorPrestamo;
use App\Models\InventarioDetalle;
use App\Models\VsEquiposPorTicket;
use App\Models\VsTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;



class EquipoController extends Controller
{
    public function index()
    {



    }


    public function create()
    {
        $empleados = Empleado::all()->sortBy('nombre');
        $areas = Area::all();
	$tipo_equipos = Equipo::distinct()->orderby('tipo_equipo','asc')->get(['tipo_equipo']);
        return view('equipo.create')->with('empleados', $empleados)->with('areas', $areas)->with('tipo_equipos', $tipo_equipos);
    }

    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'udg_id'=>'required',
            'tipo_equipo'=>'required',
            'marca'=>'required',
            'modelo'=>'required',
            'numero_serie'=>'required',
            'mac'=>'required',
            'ip'=>'required',
            'tipo_conexion'=>'required',
            'detalles'=>'required'
            ]);
        $equipo = new equipo();
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = $request->input('tipo_equipo');
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');
        $equipo->ip = $request->input('ip');
        $equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
	$equipo->resguardante = $request->input('resguardante');
        $equipo->localizado_sici = $request->input('localizado_sici');

        $equipo->save();

        return redirect('home')->with(array(
            'message'=>'El equipo se guardo Correctamente'
        ));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $empleados = Empleado::all()->sortBy('nombre');
	$tipo_equipos = Equipo::distinct()->orderby('tipo_equipo','asc')->get(['tipo_equipo']);

        $equipo = VsEquipo::find($id);
        if($equipo){
            $idResguardante=$equipo->id_resguardante;
            if($idResguardante==0){
                $idResguardante=39;
            }
            $resguardante = Empleado::find($idResguardante);
            return view('equipo.edit')->with('equipo', $equipo)->with('empleados', $empleados)->with('resguardante',$resguardante)->with('tipo_equipos', $tipo_equipos);
        }else{
            return redirect('home')->with(array(
                'message'=>'El Id que desea modificar no existe'
            ));
        }


    }


    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'udg_id'=>'required',
            'tipo_equipo'=>'required',
            'marca'=>'required',
            'modelo'=>'required',
            'numero_serie'=>'required',
            'mac'=>'required',
            'ip'=>'required',
            'tipo_conexion'=>'required',
            'detalles'=>'required'
        ]);
        $equipo = Equipo::find($id);
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = $request->input('tipo_equipo');
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');
        $equipo->ip = $request->input('ip');
        $equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
	$equipo->resguardante = $request->input('resguardante');
        $equipo->localizado_sici = $request->input('localizado_sici');

        $equipo->update();

        return redirect('home')->with(array(
            'message'=>'El equipo se actualizó correctamente'
        ));
    }


    public function destroy($id)
    {
        //
    }


    public function revisionInventario(){
        return view('equipo.revision-inventario');
    }
    public function busquedaAvanzada(){
        return view('equipo.busquedaAvanzada');
    }
    public function busqueda(Request $request){
        $validateData = $this->validate($request,[
           'busqueda'=>'required'
           ]);

       $busqueda = $request->input('busqueda');
       if(isset($busqueda) && !is_null($busqueda)){
           $equipos = VsEquipo::where('activo','=',1)
               ->where('id','=',$busqueda)
               ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
               ->orWhere('marca','LIKE','%'.$busqueda.'%')
               ->orWhere('marca','LIKE','%'.$busqueda.'%')
               ->orWhere('modelo','LIKE','%'.$busqueda.'%')
               ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
               ->orWhere('mac','LIKE','%'.$busqueda.'%')
               ->orWhere('ip','LIKE','%'.$busqueda.'%')
               ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
               ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
               ->orWhere('area','LIKE','%'.$busqueda.'%')->get();

           return view('equipo.busqueda')->with('equipos',$equipos)->with('busqueda', $busqueda);
       }else{
           return redirect('home')->with(array(
               'message'=>'Debe introducir un término de búsqueda'
           ));
       }

    }
    public function busquedaEquiposTicket(Request $request){
        $validateData = $this->validate($request,[
            'busqueda'=>'required'
        ]);

        $busqueda = $request->input('busqueda');
        $ticket_id = $request->input('ticket_id');
        $ticket = VsTicket::find($ticket_id);
        if(isset($busqueda) && !is_null($busqueda)){
            $equipos = VsEquipo::where('id','=',$busqueda)
                ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('modelo','LIKE','%'.$busqueda.'%')
                ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
                ->orWhere('mac','LIKE','%'.$busqueda.'%')
                ->orWhere('ip','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
                ->orWhere('area','LIKE','%'.$busqueda.'%')->get();
            $equipoPorTickets = VsEquiposPorTicket::where('ticket_id','=', $ticket_id)->get();
            return view('ticket.agregarEquiposTicket')->with('equipos',$equipos)->with('busqueda', $busqueda)
                ->with('ticket', $ticket)->with('ticket_id', $ticket_id)->with('equipoPorTickets', $equipoPorTickets);
        }else{
            return redirect('home')->with(array(
                'message'=>'Debe introducir un término de búsqueda'
            ));
        }

    }

public function busquedaEquiposPrestamo(Request $request){
        $validateData = $this->validate($request,[
            'busqueda'=>'required'
        ]);

        $busqueda = $request->input('busqueda');
        $prestamo_id = $request->input('prestamo_id');
        $prestamo = VsPrestamo::find($prestamo_id);
        if(isset($busqueda) && !is_null($busqueda)){
            $equipos = VsEquipo::where('id','=',$busqueda)
                ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('modelo','LIKE','%'.$busqueda.'%')
                ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
                ->orWhere('mac','LIKE','%'.$busqueda.'%')
                ->orWhere('ip','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
                ->orWhere('area','LIKE','%'.$busqueda.'%')->get();
            $equipoPorPrestamo = EquipoPorPrestamo::where('id_prestamo','=', $prestamo_id)->get();
            return view('prestamo.agregarEquiposPrestamo')->with('equipos',$equipos)->with('busqueda', $busqueda)
                ->with('prestamo', $prestamo )->with('prestamo_id', $prestamo_id)->with('equipoPorPrestamo', $equipoPorPrestamo);
        }else{
            return redirect('home')->with(array(
                'message'=>'Debe introducir un término de búsqueda'
            ));
        }

    }
    public function inventario_cta(){
        //Se hace la ruta, la ruta manda llamar el método y el método manda llamar la plantilla
        $equipos = VsEquipo::where('activo', '=', 1)
            ->Where('resguardante', '=', 'CTA')->get();

        return view('equipo.inventariocta', array(
            'equipos' => $equipos

        ));

    }
}
