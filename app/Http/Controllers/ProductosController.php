<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;


class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::leftjoin('categorias', 'productos.id_categoria', '=', 'categorias.id')
            ->select('productos.*', 'categorias.name as nombre_categoria')
            ->get();
        return view("productos.index", compact("productos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view("productos.create", compact("categorias"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'presentacion_producto' => 'required',
            'categoria' => 'required',
            'precio_unitario' => 'required',
            'cantidad' => 'required',
        ]);

        $producto = new Producto();
        $producto->name = $request->nombre;
        $producto->presentacion_producto = $request->presentacion_producto;
        $producto->id_categoria = $request->categoria;
        $producto->precio_unitario = $request->precio_unitario;
        $producto->cantidad = $request->cantidad;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::join('categorias', 'productos.id_categoria', '=', 'categorias.id')
            ->select('productos.*', 'categorias.name as nombre_categoria')
            ->where('productos.id', '=', $id)
            ->firstOrFail();
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'presentacion_producto' => 'required',
            'categoria' => 'required',
            'precio_unitario' => 'required',
            'cantidad' => 'required',
        ]);

        $producto = Producto::find($id);
        $producto->name = $request->nombre;
        $producto->presentacion_producto = $request->presentacion_producto;
        $producto->id_categoria = $request->categoria;
        $producto->precio_unitario = $request->precio_unitario;
        $producto->cantidad = $request->cantidad;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
