@extends('layouts.user_type.auth')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .card-gasto {
            background-color: #e24a68;
            color: white;
        }

        .card-ganancia {
            background-color: #2dce89;
            color: white;
        }
    </style>
@endsection

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Detalles de producción de: {{ $produccion->nombre }}</h5>
                                </div>
                                <a href="{{ route('produccion.index') }}" class="btn bg-danger btn-sm mb-0 text-white me-2"
                                    type="button">Volver</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">

                        </div>
                    </div>
                </div>
                @php
                    $ganancia = $produccion->precio_total - $produccion->gasto_total;
                    $porcentaje = ($ganancia * 100) / $produccion->precio_total;
                    $porcentaje = round($porcentaje, 0, PHP_ROUND_HALF_DOWN);
                @endphp
                <div class="col-md-6">
                    <div class="card mb-4 mx-4 card-ganancia">
                        <div class="card-header pb-0 card-ganancia">
                            <div class="d-flex flex-row justify-content-between">
                                <b>Ganancias Totales</b>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1 class="text-white">S/ {{ $ganancia }} ({{ $porcentaje }}%)</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 mx-4 card-gasto">
                        <div class="card-header pb-0 card-gasto">
                            <div class="d-flex flex-row justify-content-between">
                                <b>Gatos Totales</b>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1 class="text-white">S/ {{ $produccion->gasto_total }} ({{ 100 - $porcentaje }}%)</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                Materiales Directos
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1>S/ {{ $gastos['gasto_total_insumos'] }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                Mano de Obra Directa
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1>S/ {{ $gastos['gasto_total_colaboradores'] }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                Costos Indirectos
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1>S/ {{ $gastos['gasto_total_maquinarias'] }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <h5 class="mb-0">Materiales Directos (Insumos)</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-sm">Nombre</th>
                                            <th class="text-center text-sm">Cantidad</th>
                                            <th class="text-center text-sm">Precio</th>
                                            <th class="text-center text-sm">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (empty($insumos))
                                            <tr>
                                                <td colspan="4" class="text-center text-sm">No hay insumos registrados
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($insumos as $insumo)
                                                <tr>
                                                    <td class="text-center text-sm">{{ $insumo->name }}</td>
                                                    <td class="text-center text-sm">{{ $insumo->cantidad }}</td>
                                                    <td class="text-center text-sm">S/. {{ $insumo->precio_presentacion }}
                                                    </td>
                                                    <td class="text-center text-sm">S/. {{ $insumo->gasto }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <h5 class="mb-0">Mano de Obra Directa (Colaboradores)</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-sm">Nombre Completo</th>
                                            <th class="text-center text-sm">Tiempo Trabajo</th>
                                            <th class="text-center text-sm">Sueldo Hora</th>
                                            <th class="text-center text-sm">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (empty($colaboradores))
                                            <tr>
                                                <td colspan="4" class="text-center text-sm">No hay colaboradores
                                                    registrados
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($colaboradores as $colaborador)
                                                <tr>
                                                    <td class="text-center text-sm">
                                                        {{ $colaborador->name . ' ' . $colaborador->last_name }}</td>
                                                    <td class="text-center text-sm">
                                                        {{ $colaborador->tiempo_trabajo . ' ' . $colaborador->tiempo_formato }}
                                                    </td>
                                                    <td class="text-center text-sm">S/.
                                                        {{ $colaborador->sueldo_hora }}
                                                    </td>
                                                    <td class="text-center text-sm">S/. {{ $colaborador->gasto }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <h5 class="mb-0">Costos Indirectos (Mquinarias)</h5>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-sm">Nombre</th>
                                            <th class="text-center text-sm">Tiempo Trabajo</th>
                                            <th class="text-center text-sm">Gasto Hora</th>
                                            <th class="text-center text-sm">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (empty($maquinarias))
                                            <tr>
                                                <td colspan="4" class="text-center text-sm">No hay maquinarias
                                                    registrados
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($maquinarias as $maquinaria)
                                                <tr>
                                                    <td class="text-center text-sm">
                                                        {{ $maquinaria->nombre }}</td>
                                                    <td class="text-center text-sm">
                                                        {{ $maquinaria->tiempo_trabajo . ' ' . $maquinaria->tiempo_formato }}
                                                    </td>
                                                    <td class="text-center text-sm">S/.
                                                        {{ $maquinaria->precio_consumo_hora }}
                                                    </td>
                                                    <td class="text-center text-sm">S/. {{ $maquinaria->gasto }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@endsection
