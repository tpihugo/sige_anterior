<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\MovimientoEquipo;

use App\Models\VsEquipo;
use App\Models\VsHistorialEquipos;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }
    public function historial($equipo_id){
        $equipo=VsEquipo::find($equipo_id);
        $historialMovimientos = VsHistorialEquipos::where('id_equipo','=',$equipo_id)->get();
        return view('equipo.historial')->with('historialMovimientos', $historialMovimientos)->with('equipo',$equipo);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $tipo = null)
    {
        $equipo = Equipo::find($id);
        $areas = Area::all();
        $usuarios = Empleado::all();
        return view('equipo.movimiento')->with('equipo', $equipo)->with('areas', $areas)->with('usuarios', $usuarios)->with('tipo', $tipo);
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
            'id_equipo'=>'required',
            'id_area'=>'required',
            'id_usuario'=>'required',
            'registro'=>'required',
            'fecha'=>'required',
            'comentarios'=>'required'
        ]);
        $movimiento = new MovimientoEquipo();
        $movimiento->id_equipo = $request->input('id_equipo');
        $movimiento->id_area = $request->input('id_area');
        $movimiento->id_usuario = $request->input('id_usuario');
        $movimiento->registro = $request->input('registro');
        $movimiento->fecha = $request->input('fecha');
        $movimiento->comentarios = $request->input('comentarios');
        $movimiento->save();
        $tipo = $request->input('tipo');
        if($tipo=='inventario'){
            return redirect('revision-inventario')->with(array(
                'message'=>'El equipo se actualizo, ya puede volverlo a buscar en inventario'
            ));
        }
        else{
            return redirect('home')->with(array(
                'message'=>'El equipo se cambió de ubicación correctamente'
            ));
        }
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
        //
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
        //
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
}
