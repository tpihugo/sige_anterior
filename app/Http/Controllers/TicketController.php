<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\Tecnico;
use App\Models\Ticket;
use App\Models\VsAreaTicket;
use App\Models\VsEquiposPorTicket;
use App\Models\VsTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\EquipoTicket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = VsTicket::where('activo','=',1)
            ->where('estatus','=','Abierto')
            ->where('categoria','<>','Reporte de aula')->get();
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos);
    }
    public function revisionTickets()
    {
        $tickets = VsTicket::where('activo','=',1)->get();
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipos = Equipo::all();
        //$areas = Area::pluck('id','area')->prepend('seleciona');
        $areas = Area::all();
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.create')->with('equipos', $equipos)->with('areas', $areas)->with('tecnicos', $tecnicos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'area_id'=>'required',
            'solicitante'=>'required',
            'contacto'=>'required',
            'tecnico_id'=>'required',
            'categoria'=>'required',
            'prioridad'=>'required',
            'estatus'=>'required',
            'datos_reporte'=>'required',
            'fecha_reporte'=>'required'
        ]);
        $ticket = new Ticket();
        $ticket->area_id = $request->input('area_id');
        $ticket->solicitante = $request->input('solicitante');
        $ticket->contacto = $request->input('contacto');
        $ticket->tecnico_id = $request->input('tecnico_id');
        $ticket->categoria = $request->input('categoria');
        $ticket->prioridad = $request->input('prioridad');
        $ticket->estatus = $request->input('estatus');
        $ticket->datos_reporte = $request->input('datos_reporte');
        $ticket->fecha_reporte = $request->input('fecha_reporte');
        $ticket->fecha_inicio  = $request->input('fecha_inicio ');
        $ticket->fecha_termino = $request->input('fecha_termino');
        $ticket->problema = $request->input('problema');
        $ticket->solucion = $request->input('solucion');
        $ticket->save();
        return redirect('tickets')->with(array(
            'message'=>'El Ticket se guardo Correctamente'
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipos = Equipo::all();
        //$areas = Area::pluck('id','area')->prepend('seleciona');
        $areas = Area::all();
        $ticket = VsTicket::find($id);
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.edit')->with('ticket', $ticket)->with('equipos', $equipos)->with('areas', $areas)->with('tecnicos',$tecnicos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'area_id'=>'required',
            'solicitante'=>'required',
            'contacto'=>'required',
            'tecnico_id'=>'required',
            'categoria'=>'required',
            'prioridad'=>'required',
            'estatus'=>'required',
            'datos_reporte'=>'required',
            'fecha_reporte'=>'required'
        ]);

        $ticket = Ticket::find($id);
        $ticket->area_id = $request->input('area_id');
        $ticket->solicitante = $request->input('solicitante');
        $ticket->contacto = $request->input('contacto');
        $ticket->tecnico_id = $request->input('tecnico_id');
        $ticket->categoria = $request->input('categoria');
        $ticket->prioridad = $request->input('prioridad');
        $ticket->estatus = $request->input('estatus');
        $ticket->datos_reporte = $request->input('datos_reporte');
        $ticket->fecha_reporte = $request->input('fecha_reporte');
        $ticket->fecha_inicio  = $request->input('fecha_inicio ');

        $ticket->fecha_termino = $request->input('fecha_termino');
        if(!is_null($ticket->fecha_termino) && isset($ticket->fecha_termino)){
            $ticket->estatus='Cerrado';
        }
        $ticket->problema = $request->input('problema');
        $ticket->solucion = $request->input('solucion');
        $ticket->update();
        return redirect('tickets')->with(array(
            'message'=>'El Ticket se guardo Correctamente'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filtroTickets(Request $request){
        $tecnicos = Tecnico::where('activo','=',1)->get();
        $tecnico = $request->input('tecnico_id');
        $estatus = $request->input('estatus');
        $tecnicoElegido = Tecnico::find($tecnico);

        if((isset($tecnico) && !is_null($tecnico)) && (isset($estatus) && !is_null($estatus))){
            $tickets = VsTicket::where('tecnico_id','=',$tecnico)
                ->Where('activo','=', 1)
                ->Where('estatus','=', $estatus)
                ->get();
        }elseif((isset($tecnico) && !is_null($tecnico)) && (!isset($estatus) && is_null($estatus))){
            $tickets = VsTicket::where('tecnico_id','=',$tecnico)
                ->Where('activo','=', 1)
                ->get();
        }elseif((!isset($tecnico) && is_null($tecnico)) && (isset($estatus) && !is_null($estatus))){
            $tickets = VsTicket::where('estatus','=',$estatus)
                ->Where('activo','=', 1)
                ->get();
        }else{
            $tickets = VsTicket::where('activo','=',1)->get();
        }
        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos)
            ->with('tecnicoElegido',$tecnicoElegido)->with('estatus',$estatus);
    }
    public function recepcionEquipo($ticket_id){
        $ticket = VsTicket::find($ticket_id);
        $equipoPorTickets = VsEquiposPorTicket::where('ticket_id','=', $ticket_id)->get();
        return view('ticket.agregarEquiposTicket')->with('ticket', $ticket)->with('ticket_id', $ticket_id)->with('equipoPorTickets', $equipoPorTickets);
    }
    public function registrarEquipoTicket($equipo_id, $ticket_id){
         $equipoTicket = new EquipoTicket();
        $equipoTicket->ticket_id = $ticket_id;
        $equipoTicket->equipo_id = $equipo_id;
        $equipoTicket->save();
        return redirect('recepcionEquipo/'.$ticket_id)->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
        ));
    }
    public function eliminarEquipoTicket($equipo_id, $ticket_id){
        EquipoTicket::where('ticket_id','=',$ticket_id)->where('equipo_id','=',$equipo_id)->delete();
        return redirect('recepcionEquipo/'.$ticket_id)->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
        ));
    }
    public function delete_ticket($ticket_id){
        $ticket = Ticket::find($ticket_id);
        if($ticket){
            $ticket->activo = 0;
            $ticket->update();
            return redirect()->route('tickets.index')->with(array(
                "message" => "El ticket se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
                "message" => "El ticket que trata de eliminar no existe"
            ));
        }

    }
    public function agregarComentario(Request $request){
       $ticket_equipo = EquipoTicket::where('ticket_id','=',$request->input('ticket_id'))->where('equipo_id','=',$request->input('equipo_id'))->first();
       $ticket_equipo->comentarios = $request->input('comentarios');
       $ticket_equipo->update();
       return redirect('recepcionEquipo/'.$request->input('ticket_id'))->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
       ));
    }
    public function historial($id = 1){
       $tickets = VsTicket::where('activo','=',1)->where('area_id','=',$id)->get();
       $tecnicos = Tecnico::where('activo','=',1)->get();
       return view('ticket.index')->with('tickets',$tickets)->with('tecnicos',$tecnicos);
    }

}
