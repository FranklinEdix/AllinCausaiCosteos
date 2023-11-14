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
                                    <h5 class="mb-0">Administrar Proveedores</h5>
                                </div>
                                <a href="{{ route('proveedores.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp; Nuevo
                                    Proveedor</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="table-responsive p-3">
                                <table id="proveedores" class="table table-striped align-items-center mb-0">
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
                                                RUC
                                            </th>
                                            <th class="text-center text-uppercase text-dark text-xxs font-weight-bolder">
                                                Dirección
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
                                        @if (empty($proveedores))
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h4>No hay proveedores registradas</h4>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($proveedores as $proveedor)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $i++ }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $proveedor->name }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $proveedor->ruc }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $proveedor->direccion }}</p>
                                                    </td>
                                                    <td class="d-flex">

                                                        <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                                                            class="mx-3 btn btn-dark" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('proveedores.destroy', $proveedor->id) }}"
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
        new DataTable('#proveedores', {
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
