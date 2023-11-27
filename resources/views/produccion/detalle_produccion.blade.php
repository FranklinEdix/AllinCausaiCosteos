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
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                Ganancias Totales
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1>500</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                Gatos Totales
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="text-center">
                                <h1>500</h1>
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
                                <h1>500</h1>
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
                                <h1>500</h1>
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
                                <h1>500</h1>
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
                                        <tr>
                                            <td class="text-center text-sm">Insumo Uno</td>
                                            <td class="text-center text-sm">30</td>
                                            <td class="text-center text-sm">S/. 20</td>
                                            <td class="text-center text-sm">S/. 600</td>
                                        </tr>
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
                                            <th class="text-center text-sm">Nombre</th>
                                            <th class="text-center text-sm">Cantidad</th>
                                            <th class="text-center text-sm">Precio</th>
                                            <th class="text-center text-sm">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-sm">Insumo Uno</td>
                                            <td class="text-center text-sm">30</td>
                                            <td class="text-center text-sm">S/. 20</td>
                                            <td class="text-center text-sm">S/. 600</td>
                                        </tr>
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
                                            <th class="text-center text-sm">Cantidad</th>
                                            <th class="text-center text-sm">Precio</th>
                                            <th class="text-center text-sm">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-sm">Insumo Uno</td>
                                            <td class="text-center text-sm">30</td>
                                            <td class="text-center text-sm">S/. 20</td>
                                            <td class="text-center text-sm">S/. 600</td>
                                        </tr>
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
