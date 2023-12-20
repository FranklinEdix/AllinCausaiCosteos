<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\AlmacenProducto;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\InventarioAlmacen;
use App\Models\insumo;
use App\Exports\InventarioExport;
use PDF;
use Maatwebsite\Excel\Facades\Excel;


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
        ->select('almacen_productos.*','productos.name as nombre_producto', 'almacens.name as nombre_almacen')
        ->where('almacen_productos.id_almacen', $id)
        ->get();
        foreach($almacen_productos as $value){
            $value->tipo = 1;
        }

        $almacen_insumos = AlmacenProducto::join('insumos', 'almacen_productos.id_insumo', '=', 'insumos.id')
        ->join('almacens', 'almacen_productos.id_almacen', '=', 'almacens.id')
        ->select('almacen_productos.*','insumos.name as nombre_producto', 'almacens.name as nombre_almacen')
        ->where('almacen_productos.id_almacen', $id)
        ->get();

        foreach($almacen_insumos as $value){
            $value->tipo = 2;
        }

        $almacen_productos = $almacen_productos->merge($almacen_insumos);
        //return $almacen_productos;
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
        $insumos = Insumo::all();
        $proveedores = Proveedore::all();
        return view('almacen.productos.add', compact('almacen', 'productos', 'proveedores', 'insumos'));
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

        if($request->tipo_producto == 1){
            $this->validate($request, [
                'producto'=>'required'
            ]);
            $producto = AlmacenProducto::where('id_almacen', $id)->where('id_producto', $request->producto)->first();
            if($producto){
                $producto->cantidad = $producto->cantidad + $request->cantidad;
                $producto->save();
                $detalle = [
                    'cantidad' => $request->cantidad,
                    'tipo' => 1,
                    'doc' => $request->doc
                ];

                $registrar_movimiento = new InventarioAlmacen();
                $registrar_movimiento->id_almacen = $id;
                $registrar_movimiento->id_producto = $request->producto;
                $registrar_movimiento->detalle = json_encode($detalle);
                $registrar_movimiento->save();
                return redirect()->route('almacen.show', $id)->with('success','Producto agregado satisfactoriamente');
            }
            $almacen_producto = new AlmacenProducto();
            $almacen_producto->id_almacen = $id;
            $almacen_producto->id_producto = $request->producto;
            $almacen_producto->cantidad = $request->cantidad;
            $almacen_producto->presentacion = $request->presentacion;
            $almacen_producto->doc = $request->doc;
            $almacen_producto->save();

            $detalle = [
                'cantidad' => $request->cantidad,
                'tipo' => 1,
                'doc' => $request->doc
            ];

            $registrar_movimiento = new InventarioAlmacen();
            $registrar_movimiento->id_almacen = $id;
            $registrar_movimiento->id_producto = $request->producto;
            $registrar_movimiento->detalle = json_encode($detalle);
            $registrar_movimiento->save();
        }
        if($request->tipo_producto == 2){
            $this->validate($request, [
                'insumo'=>'required'
            ]);
            $insumo = AlmacenProducto::where('id_almacen', $id)->where('id_insumo', $request->insumo)->first();
            if($insumo){
                $insumo->cantidad = $insumo->cantidad + $request->cantidad;
                $insumo->save();
                $detalle = [
                    'cantidad' => $request->cantidad,
                    'tipo' => 2,
                    'doc' => $request->doc
                ];

                $registrar_movimiento = new InventarioAlmacen();
                $registrar_movimiento->id_almacen = $id;
                $registrar_movimiento->id_insumo = $request->insumo;
                $registrar_movimiento->detalle = json_encode($detalle);
                $registrar_movimiento->save();
                return redirect()->route('almacen.show', $id)->with('success','Producto agregado satisfactoriamente');
            }

            $almacen_producto = new AlmacenProducto();
            $almacen_producto->id_almacen = $id;
            $almacen_producto->id_insumo = $request->insumo;
            $almacen_producto->id_proveedor = $request->proveedor;
            $almacen_producto->cantidad = $request->cantidad;
            $almacen_producto->presentacion = $request->presentacion;
            $almacen_producto->doc = $request->doc;
            $almacen_producto->save();

            $detalle = [
                'cantidad' => $request->cantidad,
                'tipo' => 2,
                'doc' => $request->doc
            ];

            $registrar_movimiento = new InventarioAlmacen();
            $registrar_movimiento->id_almacen = $id;
            $registrar_movimiento->id_insumo = $request->insumo;
            $registrar_movimiento->detalle = json_encode($detalle);
            $registrar_movimiento->save();
        }

        return redirect()->route('almacen.show', $id)->with('success', 'Producto agregado satisfactoriamente');
    }

    public function removeProducto(string $id)
    {
        $almacen_productos = AlmacenProducto::find($id);
        $id_almacen = $almacen_productos->id_almacen;
        $almacen_productos->delete();
        return redirect()->route('almacen.show', $id_almacen)->with('success', 'Producto removido del almacén satisfactoriamente');
    }

    public function retirarProducto(string $id)
    {
        $almacen = Almacen::find($id);
        $productos = AlmacenProducto::join('productos', 'almacen_productos.id_producto', '=', 'productos.id')
                                    ->select('almacen_productos.*', 'productos.name as nombre_producto')
                                    ->where('almacen_productos.id_almacen', $id)
                                    ->get();
        $insumos = AlmacenProducto::join('insumos', 'almacen_productos.id_insumo', '=', 'insumos.id')
                                    ->select('almacen_productos.*', 'insumos.name as nombre_producto')
                                    ->where('almacen_productos.id_almacen', $id)
                                    ->get();
        $destinos = Almacen::where('id', '!=', $id)->get();
        return view('almacen.productos.retirar', compact('almacen', 'productos', 'destinos', 'insumos'));
    }

    public function retirarProductoAlmacen(Request $request, string $id)
    {
        $this->validate($request, [
            'producto' => 'required',
            'cantidad' => 'required',
        ]);

        if($request->tipo_producto == 1){
            $this->validate($request, [
                'producto'=>'required'
            ]);
            $almacen_producto = AlmacenProducto::where('id_almacen', $id)->where('id_producto', $request->producto)->first();
            if($almacen_producto->cantidad < $request->cantidad){
                return redirect()->route('almacen.show', $id)->with('error','No hay suficientes productos en el almacén');
            }
            $almacen_producto->cantidad = $almacen_producto->cantidad - $request->cantidad;
            $almacen_producto->save();

            $detalle = [
                'cantidad' => $request->cantidad,
                'tipo' => 2,
                'doc' => $request->doc
            ];

            $registrar_movimiento = new InventarioAlmacen();
            $registrar_movimiento->id_almacen = $id;
            $registrar_movimiento->id_producto = $request->producto;
            $registrar_movimiento->detalle = json_encode($detalle);
            $registrar_movimiento->save();

            if($request->lugar_destino != null){
                $id = $request->lugar_destino;
                $almacen_producto = new AlmacenProducto();
                $almacen_producto->id_almacen = $id;
                $almacen_producto->id_producto = $request->producto;
                $almacen_producto->cantidad = $request->cantidad;
                $almacen_producto->presentacion = $request->presentacion;
                $almacen_producto->doc = $request->doc;
                $almacen_producto->save();

                $detalle = [
                    'cantidad' => $request->cantidad,
                    'tipo' => 2,
                    'doc' => $request->doc
                ];

                $registrar_movimiento = new InventarioAlmacen();
                $registrar_movimiento->id_almacen = $id;
                $registrar_movimiento->id_producto = $request->producto;
                $registrar_movimiento->detalle = json_encode($detalle);
                $registrar_movimiento->save();
            }
        }else{
            $this->validate($request, [
                'insumo'=>'required'
            ]);
            $almacen_producto = AlmacenProducto::where('id_almacen', $id)->where('id_insumo', $request->insumo)->first();
            if($almacen_producto->cantidad < $request->cantidad){
                return redirect()->route('almacen.show', $id)->with('error','No hay suficientes productos en el almacén');
            }
            $almacen_producto->cantidad = $almacen_producto->cantidad - $request->cantidad;
            $almacen_producto->save();

            $detalle = [
                'cantidad' => $request->cantidad,
                'tipo' => 2,
                'doc' => $request->doc
            ];

            $registrar_movimiento = new InventarioAlmacen();
            $registrar_movimiento->id_almacen = $id;
            $registrar_movimiento->id_insumo = $request->insumo;
            $registrar_movimiento->detalle = json_encode($detalle);
            $registrar_movimiento->save();

            $almacen_producto = new AlmacenProducto();
            $almacen_producto->id_almacen = $id;
            $almacen_producto->id_insumo = $request->insumo;
            $almacen_producto->id_proveedor = $request->proveedor;
            $almacen_producto->cantidad = $request->cantidad;
            $almacen_producto->presentacion = $request->presentacion;
            $almacen_producto->doc = $request->doc;
            $almacen_producto->save();

            $detalle = [
                'cantidad' => $request->cantidad,
                'tipo' => 2,
                'doc' => $request->doc
            ];

            $registrar_movimiento = new InventarioAlmacen();
            $registrar_movimiento->id_almacen = $id;
            $registrar_movimiento->id_insumo = $request->insumo;
            $registrar_movimiento->detalle = json_encode($detalle);
            $registrar_movimiento->save();
        }

        return redirect()->route('almacen.show', $id)->with('success', 'Producto agregado satisfactoriamente');
    }

    public function verInventario(string $id, string $id_almacen, string $tipo)
    {
        if($tipo == 1){
            $producto = Producto::find($id);
        $inventario = InventarioAlmacen::join('almacen_productos', 'inventario_almacens.id_producto', '=', 'almacen_productos.id_producto')
                                        ->join('almacens', 'inventario_almacens.id_almacen', '=', 'almacens.id')
                                        ->join('productos', 'inventario_almacens.id_producto', '=', 'productos.id')
                                        ->select('inventario_almacens.*', 'almacen_productos.cantidad as cantidad_almacen', 'almacens.name as nombre_almacen')
                                        ->where('inventario_almacens.id_producto', $id)
                                        ->where('inventario_almacens.id_almacen', $id_almacen)
                                        ->get();
        }else{
        $producto = insumo::find($id);
        $inventario = InventarioAlmacen::join('almacen_productos', 'inventario_almacens.id_insumo', '=', 'almacen_productos.id_insumo')
                                        ->join('almacens', 'inventario_almacens.id_almacen', '=', 'almacens.id')
                                        ->join('insumos', 'inventario_almacens.id_insumo', '=', 'insumos.id')
                                        ->select('inventario_almacens.*', 'almacen_productos.cantidad as cantidad_almacen', 'almacens.name as nombre_almacen')
                                        ->where('inventario_almacens.id_insumo', $id)
                                        ->where('inventario_almacens.id_almacen', $id_almacen)
                                        ->get();
        }

        foreach($inventario as $value){
            $detalle = json_decode($value->detalle);
            $value->hora_registro = date('Y-m-d H:i:s', strtotime($value->created_at));
            $value->cantidad = $detalle->cantidad;
            $value->tipo = $detalle->tipo;
            $value->doc = $detalle->doc;
        }
        return view('almacen.productos.inventario', compact( 'producto', 'id_almacen', 'inventario', 'id', 'tipo'));
    }

    public function exportarInventario(Request $request, string $id, string $id_almacen)
    {
        //return $request;
        if($request->tipo_producto == 1){
            $producto = Producto::find($id);
            $inventario = InventarioAlmacen::join('almacen_productos', 'inventario_almacens.id_producto', '=', 'almacen_productos.id_producto')
                                        ->join('almacens', 'inventario_almacens.id_almacen', '=', 'almacens.id')
                                        ->join('productos', 'inventario_almacens.id_producto', '=', 'productos.id')
                                        ->select('inventario_almacens.*', 'almacen_productos.cantidad as cantidad_almacen', 'almacens.name as nombre_almacen')
                                        ->where('inventario_almacens.id_producto', $id)
                                        ->where('inventario_almacens.id_almacen', $id_almacen)
                                        ->when($request->fecha_inicio, function ($query, $fecha_inicio) {
                                            return $query->where('inventario_almacens.created_at', '>=', $fecha_inicio);
                                        })
                                        ->when($request->fecha_fin, function ($query, $fecha_fin) {
                                            return $query->where('inventario_almacens.created_at', '<=', $fecha_fin);
                                        })
                                        ->get();
            $detalle_producto = AlmacenProducto::where('id_almacen', $id_almacen)->where('id_producto', $id)->first();
        }else{
            $producto = insumo::find($id);
            $inventario = InventarioAlmacen::join('almacen_productos', 'inventario_almacens.id_insumo', '=', 'almacen_productos.id_insumo')
                                        ->join('almacens', 'inventario_almacens.id_almacen', '=', 'almacens.id')
                                        ->join('insumos', 'inventario_almacens.id_insumo', '=', 'insumos.id')
                                        ->select('inventario_almacens.*', 'almacen_productos.cantidad as cantidad_almacen', 'almacens.name as nombre_almacen')
                                        ->where('inventario_almacens.id_insumo', $id)
                                        ->where('inventario_almacens.id_almacen', $id_almacen)
                                        ->when($request->fecha_inicio, function ($query, $fecha_inicio) {
                                            return $query->where('inventario_almacens.created_at', '>=', $fecha_inicio);
                                        })
                                        ->when($request->fecha_fin, function ($query, $fecha_fin) {
                                            return $query->where('inventario_almacens.created_at', '<=', $fecha_fin);
                                        })
                                        ->get();
            $detalle_producto = AlmacenProducto::where('id_almacen', $id_almacen)->where('id_insumo', $id)->first();
        }

        foreach($inventario as $value){
            $detalle = json_decode($value->detalle);
            $value->hora_registro = date('Y-m-d H:i:s', strtotime($value->created_at));
            $value->cantidad = $detalle->cantidad;
            $value->tipo = $detalle->tipo;
        }

        if($request->tipo_reporte == 1){
            $titulo = 'Inventario';
            if($request->fecha_inicio != null && $request->fecha_fin != null){
                $fecha_inicio = date('Y-m-d H:i:s', strtotime($request->fecha_inicio));
                $fecha_fin = date('Y-m-d H:i:s', strtotime($request->fecha_fin));
                $inventario = $inventario->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
                $titulo = 'Inventario de '. $request->fecha_inicio . ' a ' . $request->fecha_fin;
            }
            $pdf = PDF::loadView('almacen.productos.export_inventario', compact( 'producto', 'id_almacen', 'inventario', 'id', 'detalle_producto', 'titulo'));
            return $pdf->download('Inventario.pdf');
            //return view('almacen.productos.export_inventario', compact( 'producto', 'id_almacen', 'inventario', 'id', 'detalle_producto', 'titulo'));
        }else{
            if($request->fecha_inicio != null && $request->fecha_fin != null){
                $fecha_inicio = date('Y-m-d H:i:s', strtotime($request->fecha_inicio));
                $fecha_fin = date('Y-m-d H:i:s', strtotime($request->fecha_fin));
                $inventario = $inventario->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
                $titulo = 'Inventario de '. $request->fecha_inicio . ' a ' . $request->fecha_fin;
            }
            return Excel::download(new InventarioExport($inventario->toArray()), 'inventario.xlsx');
        }
    }


}
