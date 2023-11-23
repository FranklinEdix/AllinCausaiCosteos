<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\AlmacenProducto;
use App\Models\Producto;
use App\Models\Proveedore;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::all();
        return view("almacen.index", compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('almacen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $almacen = new Almacen();
        $almacen->name = $request->nombre;
        $almacen->descripcion = $request->descripcion;
        $almacen->save();

        return redirect()->route('almacen.index')->with('success', 'Almacen creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $almacen_productos = AlmacenProducto::join('productos', 'almacen_productos.id_producto', '=', 'productos.id')
            ->join('almacens', 'almacen_productos.id_almacen', '=', 'almacens.id')
            ->join('proveedores', 'almacen_productos.id_proveedor', '=', 'proveedores.id') // Join con la tabla de proveedores
            ->select('almacen_productos.*', 'productos.name as nombre_producto', 'almacens.name as nombre_almacen', 'proveedores.name as nombre_proveedor') // Incluye el nombre del proveedor
            ->where('almacen_productos.id_almacen', $id)
            ->get();

        $almacen = Almacen::find($id);

        return view('almacen.show', compact('almacen_productos', 'almacen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $almacen = Almacen::find($id);
        return view('almacen.edit', compact('almacen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $almacen = Almacen::find($id);
        $almacen->name = $request->nombre;
        $almacen->descripcion = $request->descripcion;
        $almacen->save();

        return redirect()->route('almacen.index')->with('success', 'Almacen actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Almacen::find($id)->delete();
        return redirect()->route('almacen.index')->with('success', 'Almacen eliminado satisfactoriamente');
    }

    public function agregarProducto(string $id)
    {
        $almacen = Almacen::find($id);
        $productos = Producto::all();
        $proveedores = Proveedore::all();
        return view('almacen.productos.add', compact('almacen', 'productos', 'proveedores'));
    }

    public function addproductoAlmacen(Request $request, $id)
    {
        $this->validate($request, [
            'producto' => 'required',
            'proveedor' => 'required',
            'cantidad' => 'required',
            'presentacion' => 'required',
            'doc' => 'required'

        ]);

        $almacen_producto = new AlmacenProducto();
        $almacen_producto->id_almacen = $id;
        $almacen_producto->id_producto = $request->producto;
        $almacen_producto->id_proveedor = $request->proveedor;
        $almacen_producto->cantidad = $request->cantidad;
        $almacen_producto->presentacion = $request->presentacion;
        $almacen_producto->doc = $request->doc;
        $almacen_producto->save();

        return redirect()->route('almacen.show', $id)->with('success', 'Producto agregado satisfactoriamente');
    }

    public function removeProducto(string $id)
    {
        $almacen_productos = AlmacenProducto::find($id);
        $id_almacen = $almacen_productos->id_almacen;
        $almacen_productos->delete();
        return redirect()->route('almacen.show', $id_almacen)->with('success', 'Producto removido del almacén satisfactoriamente');
    }
}
