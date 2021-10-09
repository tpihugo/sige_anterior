<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Equipo;
use App\Models\EquipoPorPrestamo;
use App\Models\PrestamoEquipo;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\VsPrestamo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestamos = VsPrestamo::where('activo','=',1)->get();
        return view('prestamo.index')->with('prestamos',$prestamos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


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
            'id_area'=>'required',
            'solicitante'=>'required',
            'cargo'=>'required',
            'estado'=>'required',
            'fecha_inicio'=>'required',
            'observaciones'=>'required'
        ]);
        $prestamo = new Prestamo();
        $prestamo->id_area = $request->input('id_area');
        $prestamo->telefono = $request->input('telefono');
        $prestamo->solicitante = $request->input('solicitante');
        $prestamo->correo = $request->input('correo');
        $prestamo->cargo = $request->input('cargo');
        $prestamo->estado = $request->input('estado');
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->observaciones = $request->input('observaciones');
        
	$prestamo->save();

        $lastPrestamo = $prestamo->id;

        $prestamo_equipo = new PrestamoEquipo();
        $prestamo_equipo->id_prestamo = $lastPrestamo;
        $prestamo_equipo->id_equipo = $request->input('equipo_id');
        $prestamo_equipo->accesorios = $request->input('accesorios');
        $prestamo_equipo->save();

        return redirect('prestamos')->with(array(
            'message'=>'El prÃ©stamo se guardo Correctamente'
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
        $prestamo = Prestamo::find($id);
        $vsPrestamo = VsPrestamo::find($id);
        $equiposPrestados = EquipoPorPrestamo::where('id_prestamo','=',$id)
            ->where('activo','=',1)->get();

        $areas = Area::all();
        return view('prestamo.edit')->with('prestamo',$prestamo)->with('vsPrestamo',$vsPrestamo)->with('equiposPrestados',$equiposPrestados)->with('areas',$areas);
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
            'id_area'=>'required',
            'solicitante'=>'required',
            'cargo'=>'required',
            'estado'=>'required',
            'fecha_inicio'=>'required',
            'observaciones'=>'required'
        ]);
        $prestamo = Prestamo::find($id);
        $prestamo->id_area = $request->input('id_area');
        $prestamo->telefono = $request->input('telefono');
        $prestamo->solicitante = $request->input('solicitante');
        $prestamo->correo = $request->input('correo');
        $prestamo->cargo = $request->input('cargo');
        $prestamo->estado = $request->input('estado');
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->observaciones = $request->input('observaciones');
        $documento = $request->file('documento');
        if($documento){
            $documento_path = time().$documento->getClientOriginalName();
            \Storage::disk('documentos')->put($documento_path, \File::get($documento));
            $prestamo->documento = $documento_path;
        }
        $prestamo->update();

        return redirect('prestamos')->with(array(
            'message'=>'El prÃ©stamo se guardo Correctamente'
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
    public function generarPrestamo($equipo_id){
        $areas = Area::all();
        $equipoPrestamo = Equipo::find($equipo_id);
        return view('prestamo.create')->with('areas', $areas)->with('equipoPrestamo', $equipoPrestamo);
    }

    public function quitarEquipoPrestado($equipo_prestado_id, $prestamo_id){

        $equipoPrestado = PrestamoEquipo::find($equipo_prestado_id);
        $equipoPrestado->activo = 0;
        $equipoPrestado->update();


        return view('home');
    }
    public function delete_prestamo($prestamo_id){
        $prestamo = Prestamo::find($prestamo_id);
        if($prestamo){
            $prestamo->activo = 0;
            $prestamo->update();
            return redirect()->route('prestamos.index')->with(array(
                "message" => "El prestamo se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
                "message" => "El prestamo que trata de eliminar no existe"
            ));
        }

    }

    public function obtenerdocumento($filename){
        $file = Storage::disk('documentos')->get($filename);
        return new Response($file, 200);
    }
    public function prestamoEquipos($prestamo_id){
        $prestamo = VsPrestamo::find($prestamo_id);
        $equipoPorPrestamo = EquipoPorPrestamo::where('id_prestamo','=', $prestamo_id)->get();
        return view('prestamo.agregarEquiposPrestamo')->with('prestamo', $prestamo )->with('prestamo_id', $prestamo_id)->with('equipoPorPrestamo', $equipoPorPrestamo);
    }
 public function registrarEquipoPrestamo($equipo_id, $prestamo_id){
         $prestamoEquipo = new PrestamoEquipo();
        $prestamoEquipo->id_prestamo = $prestamo_id;
        $prestamoEquipo->id_equipo = $equipo_id;
	//$prestamoEquipo->accesorios = $accesorios;
        $prestamoEquipo->save();
        return redirect('prestamoEquipos/'.$prestamo_id)->with(array(
            'message'=>'El Equipo se agregÃ³ Correctamente al Préstamo'
        ));
    }

 public function eliminarEquipoPrestamo($equipo_id, $prestamo_id){
        PrestamoEquipo::where('id_prestamo','=',$prestamo_id)->where('id_equipo','=',$equipo_id)->delete();
        return redirect('prestamoEquipos/'.$prestamo_id)->with(array(
            'message'=>'El Equipo se quitó Correctamente al Préstamo'
        ));
    }

}
