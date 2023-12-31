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
                                    <h5 class="mb-0">Administrar Producción</h5>
                                </div>
                                <a href="{{ route('produccion.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; Nueva
                                    Producción</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="produccion" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-dark text-xxs font-weight-bolder">
                                                #
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Nombre
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Presentación
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Descripción
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Producto final
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio Unitario
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Cantidad de producto final
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Gasto total
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio total de productos
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Ganancia
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Porcentaje de ganancia
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
                                        @if (empty($produccion))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay maquinarias registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($produccion as $value)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->nombre }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->presentacion }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->descripcion }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->producto_final }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->precio_unitario }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->cantidad_producto_final }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->gasto_total }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->precio_total }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ number_format($value->precio_total - $value->gasto_total, 2, ',', ' ') }}
                                                        </p>
                                                    </td>
                                                    @php
                                                        $ganancia = $value->precio_total - $value->gasto_total;
                                                        $porcentaje = ($ganancia * 100) / $value->precio_total;
                                                        $porcentaje = round($porcentaje, 0, PHP_ROUND_HALF_DOWN);
                                                    @endphp
                                                    <td class="text-center">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                                <span
                                                                    class="text-xs font-weight-bold">{{ $porcentaje }}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-info w-60"
                                                                role="progressbar" aria-valuenow="{{ $porcentaje }}"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $maquinaria->precio_consumo_mensual }}</p>
                                                    </td> --}}
                                                    <td class="d-flex">
                                                        <a href="{{ route('produccion.show', $value->id) }}"
                                                            class="mx-1 btn btn-success" type="button">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($value->estado == 0)
                                                            <a href="{{ route('produccion.edit', $value->id) }}"
                                                                class="mx-3 btn btn-dark" type="button">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('produccion.destroy', $value->id) }}"
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
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-id="{{ $value->id }}"
                                                                style="margin-left: 4px !important;">
                                                                Finalizar Producción
                                                            </button>
                                                            <a href="{{ route('produccion.detalle', $value->id) }}"
                                                                class="mx-3 btn btn-primary" type="button">
                                                                Ver Detalles
                                                            </a>
                                                        @elseif ($value->estado == 1)
                                                            <a href="{{ route('produccion.detalle', $value->id) }}"
                                                                class="mx-3 btn btn-primary" type="button">
                                                                Ver Detalles
                                                            </a>
                                                        @endif
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

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Finalizar Producción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produccion.finalizar') }}" id="actualizar_produccion" method="POST">
                            @csrf
                            <input type="hidden" name="produccion_id" id="produccion_id" value="">
                            <div class="mb-3">
                                <label for="almacen" class="col-form-label">Seleccione almacen:</label>
                                <select name="almacen" id="almacen" class="form-control" required>
                                    <option value="{{ null }}">Seleccione un almacen</option>
                                    @foreach ($almacen as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Enviar">
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
        new DataTable('#produccion', {
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

    <script>
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var id = button.data('id'); // Extrae el valor del atributo data-id

                // Asigna el ID al campo oculto del formulario
                $('#produccion_id').val(id);
            });
        });
    </script>
@endsection
