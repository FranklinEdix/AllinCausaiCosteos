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
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Detalles del proceso {{ $proceso->nombre_proceso }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="p-3">
                                <a href="{{ route('produccion.show', $proceso->produccion_id) }}" class="btn btn-danger">
                                    Cerrar
                                </a>
                                <a href="{{ route('produccion.exportar.pdf', $proceso->id) }}" class="btn btn-primary">
                                    PDF
                                </a>
                                <a href="#" class="btn btn-secondary">
                                    EXCEL
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Insumos</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="insumosdetalle" class="table table-striped align-items-center mb-0">
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
                                                Cantidad
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio unitario
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (empty($insumos))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay insumos registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($insumos as $value)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->name }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->cantidad }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->precio_presentacion }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->gasto }}</p>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Maquinarias</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="maquinariasdetalle" class="table table-striped align-items-center mb-0">
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
                                                Cantidad de horas/minutos trabajados
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio por hora
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Precio total para el proceso
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (empty($maquinarias))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay maquinarias registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($maquinarias as $value)
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
                                                            @if ($value->tiempo_formato == 'min')
                                                                {{ $value->tiempo_trabajo }} minutos
                                                            @else
                                                                {{ $value->tiempo_trabajo }} horas
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->precio_consumo_hora }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->gasto }}</p>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Colaboradores</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="colaboradoresdetalle" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-dark text-xxs font-weight-bolder">
                                                #
                                            </th>
                                            <th
                                                class="text-uppercase text-center text-dark text-xxs font-weight-bolder ps-2">
                                                Nombres y Apellidos
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Cantidad de horas/minutos trabajados
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Sueldo por hora
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Gasto total para el proceso
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (empty($colaboradores))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay colaboradores registrados</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($colaboradores as $value)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->name . ' ' . $value->last_name }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            @if ($value->tiempo_formato == 'min')
                                                                {{ $value->tiempo_trabajo }} minutos
                                                            @else
                                                                {{ $value->tiempo_trabajo }} horas
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->sueldo_hora }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $value->gasto }}</p>
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
        new DataTable('#insumosdetalle', {
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

        new DataTable('#maquinariasdetalle', {
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

        new DataTable('#colaboradoresdetalle', {
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
