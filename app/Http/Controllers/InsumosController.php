<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo;

class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insumos = Insumo::all();
        return view("insumos.index", compact("insumos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("insumos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "nombre"=> "required",
            "presentacion"=>"required",
            "precio_presentacion"=> "required"
        ]);

        $insumo = new Insumo();
        $insumo->name = $request->nombre;
        $insumo->presentacion = $request->presentacion;
        $insumo->precio_presentacion = $request->precio_presentacion;
        $insumo->save();

        return redirect()->route("insumos.index")->with("success","Insumo registrado correctamente");
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
        $insumo = Insumo::find($id);
        $presentaciones = ["Kilogramo","gramo","unidad","par"];
        return view("insumos.edit", compact("insumo", "presentaciones"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            "nombre"=> "required",
            "presentacion"=> "required",
            "precio_presentacion"=> "required"
        ]);

        $insumo = Insumo::find($id);
        $insumo->name = $request->nombre;
        $insumo->presentacion = $request->presentacion;
        $insumo->precio_presentacion = $request->precio_presentacion;
        $insumo->save();

        return redirect()->route("insumos.index")->with("success","Insumo actualizado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $insumo = Insumo::find($id);
        $insumo->delete();
        return redirect()->route("insumos.index")->with("success","Insumo eliminado correctamente");
    }
}
