<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinaria;

class MaquinariasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinarias = Maquinaria::all();
        return view('maquinarias.index', compact('maquinarias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maquinarias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required',
            'precio_consumo_hora' => 'required',
        ]);

        $maquinaria = new Maquinaria();
        $maquinaria->nombre = $request->nombre;
        $maquinaria->precio_consumo_hora = $request->precio_consumo_hora;
        $maquinaria->save();

        return redirect()->route('maquinarias.index')->with('success','Maquinaria creada correctamente');
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
        $maquinaria = Maquinaria::find($id);
        return view('maquinarias.edit', compact('maquinaria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'nombre' => 'required',
            'precio_consumo_hora' => 'required',
        ]);

        $maquinaria = Maquinaria::find($id);
        $maquinaria->nombre = $request->nombre;
        $maquinaria->precio_consumo_hora = $request->precio_consumo_hora;
        $maquinaria->save();

        return redirect()->route('maquinarias.index')->with('success','Maquinaria actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maquinaria = Maquinaria::find($id);
        $maquinaria->delete();

        return redirect()->route('maquinarias.index')->with('success','Maquinaria eliminada correctamente');
    }
}
