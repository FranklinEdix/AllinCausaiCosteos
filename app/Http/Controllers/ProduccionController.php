<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produccion;
use App\Models\Maquinaria;
use App\Models\Insumo;
use App\Models\Colaborador;
use App\Models\DetailsProduccion;
use App\Models\Producto;

class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produccion = Produccion::join('productos', 'produccions.producto_final', '=', 'productos.id')
            ->select('produccions.*', 'productos.id as id_producto', 'productos.name as producto_final')
            ->get();
        $data = [];
        $gasto_total = 0;
        $detalle_produccion = [];
        foreach ($produccion as $value) {
            $id = intval($value->id_producto);
            $producto = Producto::find($id);
            $precio_total = $producto->precio_unitario * $value->cantidad_producto_final;
            $detalle_produccion =  DetailsProduccion::where('produccion_id', $value->id)->get();
            if ($detalle_produccion) {
                foreach ($detalle_produccion as $value) {
                    $gasto_total_produccion = $value->gasto_total_insumos + $value->gasto_total_maquinarias + $value->gasto_total_colaboradores;
                    $gasto_total += $gasto_total_produccion + $gasto_total;
                }
            }
            //$gasto_total = 0;//$producto->gasto_total * $value->cantidad_producto_final;
            $data[] = [
                'id' => $value->id,
                'nombre' => $value->nombre,
                'presentacion' => $value->presentacion,
                'descripcion' => $value->descripcion,
                'producto_final' => $value->producto_final,
                'cantidad_producto_final' => $value->cantidad_producto_final,
                'gasto_total' => $gasto_total,
                'precio_total' => $precio_total
            ];
        }
        //return $data;
        //return $data;
        return view('produccion.index', compact('produccion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('produccion.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'presentacion' => 'required',
            'descripcion' => 'required',
            'producto_final' => 'required',
            'cantidad_producto_final' => 'required'
        ]);

        $productos = Producto::find($request->producto_final);
        $precio_total = $request->cantidad_producto_final * $productos->precio_unitario;

        $produccion = new Produccion();
        $produccion->nombre = $request->nombre;
        $produccion->presentacion = $request->presentacion;
        $produccion->descripcion = $request->descripcion;
        $produccion->producto_final = $request->producto_final;
        $produccion->cantidad_producto_final = $request->cantidad_producto_final;
        $produccion->precio_total = $precio_total;
        $produccion->save();

        return redirect()->route('produccion.index')->with('success', 'Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produccion = Produccion::find($id);
        $procesos = DetailsProduccion::where('produccion_id', $id)->get();
        return view('produccion.show', compact('produccion', 'procesos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produccion = Produccion::find($id);
        return view('produccion.edit', compact('produccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'presentacion' => 'required',
            'descripcion' => 'required',
            'producto_final' => 'required',
            'cantidad_producto_final' => 'required'
        ]);

        $produccion = Produccion::find($id);
        $produccion->nombre = $request->nombre;
        $produccion->presentacion = $request->presentacion;
        $produccion->descripcion = $request->descripcion;
        $produccion->producto_final = $request->producto_final;
        $produccion->cantidad_producto_final = $request->cantidad_producto_final;
        $produccion->save();

        return redirect()->route('produccion.index')->with('success', 'Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produccion = Produccion::find($id);
        $produccion->delete();
        return redirect()->route('produccion.index')->with('success', 'Registro eliminado satisfactoriamente');
    }

    public function agregarProceso($id)
    {
        $produccion = Produccion::find($id);
        $insumos = Insumo::all();
        $maquinarias = Maquinaria::all();
        $colaboradores = Colaborador::all();
        return view('produccion.procesos.add', compact('produccion', 'id', 'insumos', 'maquinarias', 'colaboradores'));
    }

    public function agregarProcesoStore(Request $request, $id)
    {
        //return $request;
        $this->validate($request, []);

        $gasto_total_insumos = 0;
        $gasto_total_maquinarias = 0;
        $gasto_total_colaboradores = 0;
        $cantidad = 0;
        $precio_nuevo = 0;

        foreach ($request->insumos as $insumo) {
            $insumo = Insumo::find($insumo);
            foreach ($request->cantidad as $key => $value) {
                if ($key == $insumo->id) {
                    if (!is_null($value)) {
                        $cantidad = $value;
                    } else {
                        $cantidad = 1;
                    }
                }
            }
            $gasto_total_insumos = $insumo->precio_presentacion * $cantidad;
        }

        foreach ($request->maquinarias as $maquinaria) {
            $maquinaria = Maquinaria::find($maquinaria);
            $gasto_maquinaria = $maquinaria->precio_consumo_hora;
            foreach ($request->new_precio_maquina as $key => $value) {
                if ($key == $maquinaria->id) {
                    if (!is_null($value)) {
                        $gasto_maquinaria = $value;
                    }
                    $total = $gasto_maquinaria * $request->duracion_proceso;
                }
            }
            $gasto_total_maquinarias += $total;
        }

        foreach ($request->colaboradores as $colaborador) {
            $colaborador = Colaborador::find($colaborador);
            $gasto = $colaborador->sueldo_hora;
            foreach ($request->new_precio_colaborador as $key => $value) {
                if ($key == $colaborador->id) {
                    if (!is_null($value)) {
                        $gasto = $value;
                    }
                    $total = $gasto * $request->duracion_proceso;
                }
            }
            $gasto_total_colaboradores += $total;
        }

        $gasto_total = $gasto_total_insumos + $gasto_total_maquinarias + $gasto_total_colaboradores;

        $add_proceso = new DetailsProduccion();
        $add_proceso->produccion_id = $id;
        $add_proceso->codigo_proceso = $request->codigo_proceso;
        $add_proceso->nombre_proceso = $request->nombre;
        $add_proceso->insumo_id = implode(',', $request->insumos);
        $add_proceso->maquinaria_id = implode(',', $request->maquinarias);
        $add_proceso->colaborador_id = implode(',', $request->colaboradores);
        $add_proceso->gasto_total_insumos = $gasto_total_insumos;
        $add_proceso->gasto_total_maquinarias = $gasto_total_maquinarias;
        $add_proceso->gasto_total_colaboradores = $gasto_total_colaboradores;
        $add_proceso->save();

        $produccion = Produccion::find($id);
        $produccion->gasto_total = $produccion->gasto_total + $gasto_total;
        $produccion->save();


        return redirect()->route('produccion.show', $id)->with('success', 'Registro creado satisfactoriamente');
    }

    public function removeProceso(string $id)
    {
        $produccion_detalle = DetailsProduccion::find($id);
        $gasto_insumos = $produccion_detalle->gasto_total_insumos;
        $gasto_maquinarias = $produccion_detalle->gasto_total_maquinarias;
        $gasto_colaboradores = $produccion_detalle->gasto_total_colaboradores;
        $produccion_detalle->delete();

        $gasto_total = $gasto_insumos + $gasto_maquinarias + $gasto_colaboradores;

        $produccion = Produccion::find($produccion_detalle->produccion_id);
        $produccion->gasto_total = $produccion->gasto_total - $gasto_total;
        $produccion->save();

        return redirect()->route('produccion.index', $id)->with('success', 'Proceso eliminado satisfactoriamente');
    }
}
