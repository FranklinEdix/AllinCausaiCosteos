<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use App\Models\AreaEmpresa;

class ColaborardoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaboradores = Colaborador::join('area_empresas', 'colaboradors.id_area', '=', 'area_empresas.id')
                                    ->select('colaboradors.*', 'area_empresas.name as area')
                                    ->get();
        return view("colaboradores.index", compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = AreaEmpresa::all();
        return view('colaboradores.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre'=> 'required',
            'area'=> 'required',
            'sueldo_mensual'=> 'required',
        ]);

        $sueldo_semana = $request->sueldo_mensual / 4;
        $sueldo_dia = $sueldo_semana / 6;
        $sueldo_hora = $sueldo_dia / 8;


        $colaborador = new Colaborador();
        $colaborador->name = $request->nombre;
        $colaborador->last_name = $request->apellido;
        $colaborador->dni_carentextrangeria = $request->dni_carentextrangeria;
        $colaborador->email = $request->email;
        $colaborador->phone = $request->phone;
        $colaborador->address = $request->address;
        $colaborador->sueldo_hora = $sueldo_hora;
        $colaborador->sueldo_dia = $sueldo_dia;
        $colaborador->sueldo_semanal = $sueldo_semana;
        $colaborador->sueldo_mensual = $request->sueldo_mensual;
        $colaborador->id_area = $request->area;
        $colaborador->save();

        return redirect()->route("colaboradores.index")->with("success","Colaborador registrado correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colaborador = Colaborador::find($id);
        $areas = AreaEmpresa::all();
        $area_colaborador = '';
        foreach ($areas as $area) {
            if ($area->id == $colaborador->id_area) {
                $area_colaborador = $area->name;
            }
        }
        return view('colaboradores.edit', compact('colaborador', 'areas', 'area_colaborador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre'=> 'required',
            'area'=> 'required',
            'sueldo_mensual'=> 'required',
        ]);

        $sueldo_semana = $request->sueldo_mensual / 4;
        $sueldo_dia = $sueldo_semana / 6;
        $sueldo_hora = $sueldo_dia / 8;


        $colaborador = Colaborador::find($id);
        $colaborador->name = $request->nombre;
        $colaborador->last_name = $request->apellido;
        $colaborador->dni_carentextrangeria = $request->dni_carentextrangeria;
        $colaborador->email = $request->email;
        $colaborador->phone = $request->phone;
        $colaborador->address = $request->address;
        $colaborador->sueldo_hora = $sueldo_hora;
        $colaborador->sueldo_dia = $sueldo_dia;
        $colaborador->sueldo_semanal = $sueldo_semana;
        $colaborador->sueldo_mensual = $request->sueldo_mensual;
        $colaborador->id_area = $request->area;
        $colaborador->save();

        return redirect()->route("colaboradores.index")->with("success","Colaborador actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colaborador = Colaborador::find($id);
        $colaborador->delete();
        return redirect()->route('colaboradores.index')->with('success','Colaborador eliminado correctamente');
    }
}
