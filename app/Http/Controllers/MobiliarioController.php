<?php

namespace App\Http\Controllers;

use App\Models\Mobiliario;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\VsEmpleado;
use App\Models\VsMobiliario;
use Illuminate\Http\Request;

class MobiliarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mobiliarios = VsMobiliario::where('activo', '=', 1)->get();
        return view('mobiliario.index')->with('mobiliarios', $mobiliarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = VsEmpleado::all()->sortBy('nombre');

        $areas = Area::all();
        return view('mobiliario.create')->with('empleados', $empleados)->with('areas', $areas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request, [
            'id_udg' => 'required',
            'id_resguardante' => 'required',
            'area_id' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
            'fecha_adquisicion' => 'required',
            'estatus_sici' => 'required',
            'localizado_sici' => 'required'
        ]);
        $mobiliario = new Mobiliario();
        $mobiliario->id_udg = $request->input('id_udg');
        $mobiliario->id_resguardante = $request->input('id_resguardante');
        $mobiliario->area_id = $request->input('area_id');
        $mobiliario->descripcion = $request->input('descripcion');
        $mobiliario->ubicacion = $request->input('ubicacion');
        $mobiliario->fecha_adquisicion = $request->input('fecha_adquisicion');
        $mobiliario->estatus_sici = $request->input('estatus_sici');
        $mobiliario->localizado_sici = $request->input('localizado_sici');
        $mobiliario->save();

        return redirect('mobiliarios')->with(array(
            'message' => 'El mobiliário se guardo Correctamente'
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
        $empleados = VsEmpleado::all()->sortBy('nombre');

        $mobiliario = VsMobiliario::find($id);
        $areas = Area::all();
        return view('mobiliario.edit')->with('empleados', $empleados)->with('mobiliario', $mobiliario)->with('areas', $areas);
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
        $validateData = $this->validate($request, [
            'id_udg' => 'required',
            'id_resguardante' => 'required',
            'area_id' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
            'fecha_adquisicion' => 'required',
            'estatus_sici' => 'required',
            'localizado_sici' => 'required'
        ]);
        $mobiliario = Mobiliario::find($id);
        $mobiliario->id_udg = $request->input('id_udg');
        $mobiliario->id_resguardante = $request->input('id_resguardante');
        $mobiliario->area_id = $request->input('area_id');
        $mobiliario->descripcion = $request->input('descripcion');
        $mobiliario->ubicacion = $request->input('ubicacion');
        $mobiliario->fecha_adquisicion = $request->input('fecha_adquisicion');
        $mobiliario->estatus_sici = $request->input('estatus_sici');
        $mobiliario->localizado_sici = $request->input('localizado_sici');
        $mobiliario->save();

        return redirect('mobiliarios')->with(array(
            'message' => 'El mobiliário se actualizo correctamente'
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

    public function delete_mobiliario($mobiliario_id)
    {
        $mobiliario = Mobiliario::find($mobiliario_id);
        if ($mobiliario) {
            $mobiliario->activo = 0;
            $mobiliario->update();
            return redirect()->route('mobiliarios.index')->with(array(
                "message" => "El mobiliário se ha eliminado correctamente"
            ));
        } else {
            return redirect()->route('home')->with(array(
                "message" => "El mobiliário que trata de eliminar no existe"
            ));
        }
    }
}
