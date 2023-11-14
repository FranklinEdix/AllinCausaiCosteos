<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view("categoria.index", compact("categorias"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "nombre" => "required"
        ]);

        $categoria = new Categoria();
        $categoria->name = $request->nombre;
        $categoria->save();

        return redirect()->route("categoria.index")->with("success","Categoria creada correctamente");
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
        $categoria = Categoria::find($id);
        return view("categoria.edit", compact("categoria"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            "nombre" => "required"
        ]);

        $categoria = Categoria::find($id);
        $categoria->name = $request->nombre;
        $categoria->save();

        return redirect()->route("categoria.index")->with("success","Categoria actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();

        return redirect()->route("categoria.index")->with("success","Categoria eliminada correctamente");
    }
}
