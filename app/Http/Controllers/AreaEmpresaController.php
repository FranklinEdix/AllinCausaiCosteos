<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaEmpresa;

class AreaEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = AreaEmpresa::all();
        return view("area-empresa.index", compact("areas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("area-empresa.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "nombre" => "required",
        ]);

        $area = new AreaEmpresa();
        $area->name = $request->nombre;
        $area->save();

        return redirect()->route("areas.index")->with("success","Area creada exitosamente");
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
        $area = AreaEmpresa::find($id);
        return view("area-empresa.edit", compact("area"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            "nombre" => "required",
        ]);

        $area = AreaEmpresa::find($id);
        $area->name = $request->nombre;
        $area->save();

        return redirect()->route("areas.index")->with("success","Area actualizada exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = AreaEmpresa::find($id);
        $area->delete();

        return redirect()->route("areas.index")->with("success","Area eliminada exitosamente");
    }
}
