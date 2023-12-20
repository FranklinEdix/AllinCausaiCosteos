<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produccion;
use App\Models\Maquinaria;
use App\Models\Insumo;
use App\Models\Colaborador;
use App\Models\DetailsProduccion;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\AlmacenProducto;
use App\Models\InventarioAlmacen;

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
            $value->precio_unitario = $producto->precio_unitario;
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
        $almacen = Almacen::all();
        return view('produccion.index', compact('produccion', 'almacen'));
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
        $productos = Producto::where('id', '!=' , $produccion->producto_final)->get();
        $producto = Producto::find($produccion->producto_final);
        $produccion['nombre_producto'] = $producto->name;
        return view('produccion.edit', compact('produccion', 'productos'));
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

        $productos = Producto::find($request->producto_final);
        $precio_total = $request->cantidad_producto_final * $productos->precio_unitario;

        $produccion = Produccion::find($id);
        $produccion->nombre = $request->nombre;
        $produccion->presentacion = $request->presentacion;
        $produccion->descripcion = $request->descripcion;
        $produccion->producto_final = $request->producto_final;
        $produccion->cantidad_producto_final = $request->cantidad_producto_final;
        $produccion->precio_total = $precio_total;
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
        $gasto_total_insumos = [];
        $gasto_total_maquinarias = 0;
        $gasto_total_colaboradores = 0;
        $cantidad = 0;
        $precio_nuevo = 0;
        $insumos_data = [];
        $maquinarias_data = [];
        $colaboradores_data = [];
        $data_tiempos_procedimiento = [];
        if(isset($request->insumos)){
            foreach ($request->insumos as $insumo) {
                $insumo = Insumo::find($insumo);
                foreach ($request->cantidad as $key => $value) {
                    if ($key == $insumo->id) {
                        if(!is_null($value)){
                            $cantidad = $value;
                        }else{
                            $cantidad = 0;
                        }
                        $data_tiempos_procedimiento[] = [
                            'id' => $insumo->id,
                            'maquinaria' => 0,
                            'colaborador' => 0,
                            'insumo' => 1,
                            'gasto' => round($insumo->precio_presentacion * $cantidad, 2),
                            'cantidad' => $cantidad,
                            'tiempo_trabajo' => 0,
                            'tiempo_formato' => 'min'
                        ];
                        $gasto_total_insumos[] = round($insumo->precio_presentacion * $cantidad, 2);
                    }
                }
            }
            $insumos_data = $request->insumos;
            $gasto_total_insumos = array_sum($gasto_total_insumos);
        }
        if(empty($gasto_total_insumos)){
            $gasto_total_insumos = 0;
        }
        if (isset($request->maquinarias)) {
            foreach ($request->maquinarias as $maquinaria) {
                $maquinaria = Maquinaria::find($maquinaria);
                $gasto_maquinaria = $maquinaria->precio_consumo_hora;
                foreach ($request->new_precio_maquina as $key => $value) {
                    if ($key == $maquinaria->id) {
                        if(!is_null($value)){
                            $gasto_maquinaria = $value;
                        }
                        if($request->tiempo_maquina[$maquinaria->id] == 'min'){
                            $total = ($gasto_maquinaria * $request->tiempo_trabajo_maquina[$maquinaria->id])/60;
                            $total = round($total , 2);
                            $tiempo_maquina = 'min';
                        }else{
                            $total = $gasto_maquinaria * $request->tiempo_trabajo_maquina[$maquinaria->id];
                            $total = round($total , 2);
                            $tiempo_maquina = 'hrs';
                        }
                        $data_tiempos_procedimiento[] = [
                            'id' => $maquinaria->id,
                            'maquinaria' => 1,
                            'colaborador' => 0,
                            'insumo' => 0,
                            'gasto' => $total,
                            'tiempo_trabajo' => $request->tiempo_trabajo_maquina[$maquinaria->id] ?? 0,
                            'tiempo_formato' => $tiempo_maquina
                        ];
                    }
                }
                $gasto_total_maquinarias += $total;
            }
            $maquinarias_data = $request->maquinarias;
        }
        if(isset($request->colaboradores)) {
            foreach ($request->colaboradores as $colaborador) {
                $colaborador = Colaborador::find($colaborador);
                $gasto = $colaborador->sueldo_hora;
                foreach ($request->new_precio_colaborador as $key => $value) {
                    if ($key == $colaborador->id) {
                        if(!is_null($value)){
                            $gasto = $value;
                        }
                        if($request->tiempo[$colaborador->id] == 'min'){
                            $total = ($gasto * $request->tiempo_trabajo_colaborador[$colaborador->id])/60;
                            $total = round($total , 2);
                            $tiempo_colaborador = 'min';
                        }else{
                            $total = $gasto * $request->tiempo_trabajo_colaborador[$colaborador->id];
                            $total = round($total , 2);
                            $tiempo_colaborador = 'hrs';
                        }
                        $data_tiempos_procedimiento[] = [
                            'id' => $colaborador->id,
                            'maquinaria' => 0,
                            'colaborador' => 1,
                            'insumo' => 0,
                            'gasto' => $total,
                            'tiempo_trabajo' => $request->tiempo_trabajo_colaborador[$colaborador->id] ?? 0,
                            'tiempo_formato' => $tiempo_colaborador
                        ];
                    }
                }
                $gasto_total_colaboradores += $total;
            }
            $colaboradores_data = $request->colaboradores;
        }

        $gasto_total = $gasto_total_insumos + $gasto_total_maquinarias + $gasto_total_colaboradores;
        $gasto_total = round($gasto_total , 2);

        //return $data_tiempos_procedimiento;

        $add_proceso = new DetailsProduccion();
        $add_proceso->produccion_id = $id;
        $add_proceso->codigo_proceso = $request->codigo_proceso;
        $add_proceso->nombre_proceso = $request->nombre;
        $add_proceso->insumo_id = implode(',',$insumos_data);
        $add_proceso->maquinaria_id = implode(',',$maquinarias_data);
        $add_proceso->colaborador_id = implode(',',$colaboradores_data);
        $add_proceso->gasto_total_insumos = $gasto_total_insumos;
        $add_proceso->gasto_total_maquinarias = $gasto_total_maquinarias;
        $add_proceso->gasto_total_colaboradores = $gasto_total_colaboradores;
        $add_proceso->data_tiempos_procedimiento = json_encode($data_tiempos_procedimiento);
        $add_proceso->save();

        $produccion = Produccion::find($id);
        $produccion->gasto_total = $produccion->gasto_total + $gasto_total;
        $produccion->save();


        return redirect()->route('produccion.show', $id)->with('success','Registro creado satisfactoriamente');
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

        return redirect()->route('produccion.show', $produccion_detalle->produccion_id)->with('success', 'Proceso eliminado satisfactoriamente');
    }

    public function detalleProceso(string $id)
    {
        $proceso = DetailsProduccion::find($id);
        $data_insumos = explode(',',$proceso->insumo_id);
        $data_maquinaria = explode(',',$proceso->maquinaria_id);
        $data_colaborador = explode(',',$proceso->colaborador_id);
        $insumos = [];
        $maquinarias = [];
        $colaboradores = [];
        $data_tiempos_procedimiento = json_decode($proceso->data_tiempos_procedimiento);
            foreach ($data_insumos as $value) {
                if (!empty($value && !empty($data_tiempos_procedimiento))) {
                    $insumo = Insumo::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->insumo == 1 && $value->id == $insumo->id) {
                            $insumo->gasto = $value->gasto;
                            $insumo->cantidad = $value->cantidad;
                        }
                    }
                    $insumos[] = $insumo;
                }
            }
            foreach ($data_maquinaria as $value) {
                if (!empty($value) && !empty($data_tiempos_procedimiento)) {
                    $maquina = Maquinaria::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->maquinaria == 1 && $value->id == $maquina->id) {
                            $maquina->gasto = $value->gasto;
                            $maquina->tiempo_trabajo = $value->tiempo_trabajo;
                            $maquina->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $maquinarias[] = $maquina;
                }
            }
            foreach ($data_colaborador as $value) {
                if (!empty($value) && !empty($data_tiempos_procedimiento)) {
                    $colaborador = Colaborador::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->colaborador == 1 && $value->id == $colaborador->id) {
                            $colaborador->gasto = $value->gasto;
                            $colaborador->tiempo_trabajo = $value->tiempo_trabajo;
                            $colaborador->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $colaboradores[] = $colaborador;
                }
            }
        return view('produccion.procesos.detalle', compact('proceso', 'insumos', 'maquinarias', 'colaboradores'));
    }

    public function exportarDetalleProduccionPDF(string $id)
    {
        return $id;
        $proceso = DetailsProduccion::find($id);
        $data_insumos = explode(',',$proceso->insumo_id);
        $data_maquinaria = explode(',',$proceso->maquinaria_id);
        $data_colaborador = explode(',',$proceso->colaborador_id);
        $insumos = [];
        $maquinarias = [];
        $colaboradores = [];
        $data_tiempos_procedimiento = json_decode($proceso->data_tiempos_procedimiento);
            foreach ($data_insumos as $value) {
                if (!empty($value)) {
                    $insumos[] = Insumo::find($value);
                }
            }
            foreach ($data_maquinaria as $value) {
                if (!empty($value) && !empty($data_tiempos_procedimiento)) {
                    $maquina = Maquinaria::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->maquinaria == 1 && $value->id == $maquina->id) {
                            $maquina->gasto = $value->gasto;
                            $maquina->tiempo_trabajo = $value->tiempo_trabajo;
                            $maquina->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $maquinarias[] = $maquina;
                }
            }
            foreach ($data_colaborador as $value) {
                if (!empty($value) && !empty($data_tiempos_procedimiento)) {
                    $colaborador = Colaborador::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->colaborador == 1 && $value->id == $colaborador->id) {
                            $colaborador->gasto = $value->gasto;
                            $colaborador->tiempo_trabajo = $value->tiempo_trabajo;
                            $colaborador->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $colaboradores[] = $colaborador;
                }
            }
        //$pdf = PDF::loadView('produccion.procesos.detallePDF', compact('proceso', 'insumos', 'maquinarias', 'colaboradores'));
    }

    public function detalleProduccion(string $id)
    {
        $produccion = Produccion::join('productos', 'produccions.producto_final', '=', 'productos.id')
            ->select('produccions.*', 'productos.id as id_producto', 'productos.name as producto_final')
            ->where('produccions.id', $id)
            ->first();
        $gastos = $this->gastosPorInsumoColaboradoresMaquina($produccion->id);
        $insumos = $this->traerInsumosProduccion($produccion->id);
        $colaboradores = $this->traerColaboradoresProduccion($produccion->id);
        $maquinarias = $this->traerMaquinariasProduccion($produccion->id);
        //return $maquinarias;
        return view('produccion.detalle_produccion', compact('produccion', 'gastos', 'insumos', 'colaboradores', 'maquinarias'));
    }

    public function gastosPorInsumoColaboradoresMaquina($id)
    {
        $gasto_total_insumos = 0;
        $gasto_total_maquinarias = 0;
        $gasto_total_colaboradores = 0;
        $gasto_total_insumos = detailsProduccion::where('produccion_id', $id)->sum('gasto_total_insumos');
        $gasto_total_maquinarias = detailsProduccion::where('produccion_id', $id)->sum('gasto_total_maquinarias');
        $gasto_total_colaboradores = detailsProduccion::where('produccion_id', $id)->sum('gasto_total_colaboradores');
        $data = [
            'gasto_total_insumos' => $gasto_total_insumos,
            'gasto_total_maquinarias' => $gasto_total_maquinarias,
            'gasto_total_colaboradores' => $gasto_total_colaboradores
        ];
        return $data;
    }

    public function traerInsumosProduccion(string $id)
    {
        $gasto_total_insumos = detailsProduccion::where('produccion_id', $id)->get();
        $data = [];
        foreach ($gasto_total_insumos as $proceso) {
            $data_insumos = explode(',',$proceso->insumo_id);
            $data_tiempos_procedimiento = json_decode($proceso->data_tiempos_procedimiento);
            foreach ($data_insumos as $value) {
                if (!empty($value && !empty($data_tiempos_procedimiento))) {
                    $insumo = Insumo::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->insumo == 1 && $value->id == $insumo->id) {
                            $insumo->gasto = $value->gasto;
                            $insumo->cantidad = $value->cantidad;
                        }
                    }
                    $data[] = $insumo;
                }
            }
        }
        return $data;
    }

    public function traerColaboradoresProduccion(string $id)
    {
        $gasto_total_colaboradores = detailsProduccion::where('produccion_id', $id)->get();
        $data = [];
        foreach ($gasto_total_colaboradores as $proceso) {
            $data_colaborador = explode(',',$proceso->colaborador_id);
            $data_tiempos_procedimiento = json_decode($proceso->data_tiempos_procedimiento);
            foreach ($data_colaborador as $value) {
                if (!empty($value && !empty($data_tiempos_procedimiento))) {
                    $colaborador = Colaborador::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->colaborador == 1 && $value->id == $colaborador->id) {
                            $colaborador->gasto = $value->gasto;
                            $colaborador->tiempo_trabajo = $value->tiempo_trabajo;
                            $colaborador->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $data[] = $colaborador;
                }
            }
        }
        return $data;
    }

    public function traerMaquinariasProduccion(string $id)
    {
        $gasto_total_maquinarias = detailsProduccion::where('produccion_id', $id)->get();
        $data = [];
        foreach ($gasto_total_maquinarias as $proceso) {
            $data_maquinaria = explode(',',$proceso->maquinaria_id);
            $data_tiempos_procedimiento = json_decode($proceso->data_tiempos_procedimiento);
            foreach ($data_maquinaria as $value) {
                if (!empty($value && !empty($data_tiempos_procedimiento))) {
                    $maquina = Maquinaria::find($value);
                    foreach ($data_tiempos_procedimiento as $value) {
                        if ($value->maquinaria == 1 && $value->id == $maquina->id) {
                            $maquina->gasto = $value->gasto;
                            $maquina->tiempo_trabajo = $value->tiempo_trabajo;
                            $maquina->tiempo_formato = $value->tiempo_formato;
                        }
                    }
                    $data[] = $maquina;
                }
            }
        }
        return $data;
    }

    //Para poder almacenar en el almacen de productos
    public function finalizarProduccion(Request $request)
    {


        $produccion = Produccion::find($request->produccion_id);
        $almacenar_productos = new AlmacenProducto();
        $almacenar_productos->id_almacen = $request->almacen;
        $almacenar_productos->id_producto = $produccion->producto_final;
        $almacenar_productos->cantidad = $produccion->cantidad_producto_final;
        $almacenar_productos->presentacion = $produccion->presentacion;
        $almacenar_productos->save();

        $detalle = [
            'cantidad' => $produccion->cantidad_producto_final,
            'tipo' => 1,
            'doc' => $produccion->id,
        ];

        $registrar_movimiento = new InventarioAlmacen();
        $registrar_movimiento->id_almacen = $request->almacen;
        $registrar_movimiento->id_producto = $produccion->producto_final;
        $registrar_movimiento->detalle = json_encode($detalle);
        $registrar_movimiento->save();

        $produccion->estado = 1;
        $produccion->save();

        return redirect()->route('produccion.index')->with('success', 'Producción finalizada satisfactoriamente');
    }
}
