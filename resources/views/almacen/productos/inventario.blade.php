@extends('layouts.user_type.auth')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Registro de Movimientos del Producto: {{ $producto->name }}</h5>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn bg-gradient-primary btn-sm mb-0"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Exportar
                                    </button>
                                    <a href="{{ route('almacen.show', $id_almacen) }}"
                                        class="btn bg-danger btn-sm mb-0 text-white" type="button">Volver</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="almacen_productos_registros" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-dark text-xxs font-weight-bolder">
                                                #
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Fecha
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Registro
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Cantidad
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Documento
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (empty($inventario))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay almacenes registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($inventario as $value)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->hora_registro }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($value->tipo == 1)
                                                            <span class="badge bg-success">Ingreso</span>
                                                        @else
                                                            <span class="badge bg-danger">Salida</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->cantidad }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            <a href="{{ $value->doc }}" target="_blank"
                                                                class="mx-1 btn btn-success" type="button">
                                                                <i class="fas fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </p>
                                                    </td>
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
        {{-- Modal para exportar --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Exportar Inventario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('almacen.exportar.pdf', ['id' => $id, 'id_almacen' => $id_almacen]) }}"
                            method="GET">
                            @csrf
                            <input type="hidden" name="tipo_producto" value="{{ $tipo }}">
                            <label for="tipo_reporte">Seleccione el tipo de reporte: </label>
                            <select name="tipo_reporte" id="tipo_reporte" class="form-select form-select-sm">
                                <option value="1">PDF</option>
                                <option value="2">Excel</option>
                            </select>
                            <label for="fecha_inicio">Fecha Inicio: </label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                            <label for="fecha_fin">Fecha Fin: </label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                            <br>
                            <button type="submit" class="btn btn-primary">Exportar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                    <div class="modal-footer">

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

    <script>
        new DataTable('#almacen_productos_registros', {
            language: {
                info: 'Mostrando la página _PAGE_ de _PAGES_',
                infoEmpty: 'No hay registros disponibles',
                infoFiltered: '(filtrado de _MAX_ registros totales)',
                lengthMenu: 'Mostrar' +
                    `<select class = "form-select form-select-sm" >
                                <option value = '10' > 10 </option>
                                <option value = '25' > 25 </option>
                                <option value = '50' > 50 </option>
                                <option value = '100' > 100 </option>
                                <option value = '-1' > Todo </option>
                            </select>` + 'registros por página',
                zeroRecords: 'No se encontró nada - lo siento',
                search: 'Buscar:',
                paginate: {
                    next: '>',
                    previous: '<'
                }
            }
        });
    </script>
@endsection
