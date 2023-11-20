<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedore;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::all();
        return view("proveedores.index", compact("proveedores"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'ruc' => 'required',
            'direccion' => 'required',
            'name_contacto' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'direc_contacto' => 'required',
            'descripcion' => 'required'

        ]);

        $proveedor = new Proveedore();
        $proveedor->name = $request->nombre;
        $proveedor->ruc = $request->ruc;
        $proveedor->direccion = $request->direccion;
        $proveedor->name_contacto = $request->name_contacto;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direc_contacto = $request->direc_contacto;
        $proveedor->descripcion = $request->descripcion;
        $proveedor->save();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado satisfactoriamente');
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
        $proveedor = Proveedore::find($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'ruc' => 'required',
            'direccion' => 'required',
            'name_contacto' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'direc_contacto' => 'required',
            'descripcion' => 'required'
        ]);

        $proveedor = Proveedore::find($id);
        $proveedor->name = $request->nombre;
        $proveedor->ruc = $request->ruc;
        $proveedor->direccion = $request->direccion;
        $proveedor->name_contacto = $request->name_contacto;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direc_contacto = $request->direc_contacto;
        $proveedor->descripcion = $request->descripcion;
        $proveedor->save();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedore::find($id);
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado satisfactoriamente');
    }
}
