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
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Almacen: {{ $almacen->name }}</h5>
                                </div>
                                <div class="float-right">
                                    <a href="{{ route('almacen.agregar.producto', $almacen->id) }}"
                                        class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Agregar
                                        Productos</a>
                                    <a href="{{ route('almacen.retirar.producto', $almacen->id) }}"
                                        class="btn bg-secondary btn-sm mb-0 text-white" type="button">-&nbsp; Retirar
                                        Producto</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="almacen_productos" class="table table-striped align-items-center mb-0">
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
                                                Producto
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Proveedor
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Cantidad
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Presentación
                                            </th>
                                            <th class="text-uppercase text-dark text-xxs font-weight-bolder">
                                                Aciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (empty($almacen_productos))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay almacenes registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($almacen_productos as $almacen_producto)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ date('Y-m-d', strtotime($almacen_producto->created_at)) }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $almacen_producto->nombre_producto }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $almacen_producto->nombre_proveedor ?? 'Origen de producción' }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $almacen_producto->cantidad }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $almacen_producto->presentacion }}</p>
                                                    </td>
                                                    <td class="d-flex">
                                                        {{-- <a href="{{ route('almacen.show', $almacen_producto->id) }}"
                                                            class="mx-1 btn btn-success" type="button">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('almacen.edit', $almacen_producto->id) }}"
                                                            class="mx-3 btn btn-dark" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </a> --}}
                                                        @if ($almacen_producto->tipo == 1)
                                                            <a href="{{ route('almacen.ver.inventario', ['id' => $almacen_producto->id_producto, 'id_almacen' => $almacen->id, 'tipo' => 1]) }}"
                                                                class="btn btn-info">
                                                                Ver
                                                            </a>
                                                        @else
                                                            <a href="{{ route('almacen.ver.inventario', ['id' => $almacen_producto->id_insumo, 'id_almacen' => $almacen->id, 'tipo' => 2]) }}"
                                                                class="btn btn-info">
                                                                Ver
                                                            </a>
                                                        @endif
                                                        <form
                                                            action="{{ route('almacen.remove.producto', $almacen_producto->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger"
                                                                onclick="return confirm('¿Quieres borrar los datos?, ¡No se podrán reuperar despues!.')">
                                                                <span>
                                                                    <i class="cursor-pointer fas fa-trash"></i>
                                                                </span>
                                                            </button>
                                                        </form>
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
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        new DataTable('#almacen_productos', {
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
