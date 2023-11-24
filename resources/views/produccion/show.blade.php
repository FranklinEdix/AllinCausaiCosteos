@extends('layouts.user_type.auth')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/produccion.css') }}">
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
                                    <h5 class="mb-0">Detalle de {{ $produccion->nombre }}</h5>
                                </div>
                                <div class="">
                                    <a href="{{ route('produccion.add.proceso', $produccion->id) }}"
                                        class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Nuevo
                                        Proceso</a>
                                    <a href="{{ route('produccion.index') }}"
                                        class="btn bg-gradient-danger btn-sm mb-0">Volver</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 mt-4">
                            <div class="page">
                                <div class="timeline">
                                    @foreach ($procesos as $proceso)
                                        <div class="timeline__group">
                                            <span class="timeline__year time"
                                                aria-hidden="true">{{ $proceso->nombre_proceso }}</span>
                                            <div class="timeline__cards">
                                                <div class="timeline__card card">
                                                    <header class="card__header">
                                                        <time class="time" datetime="2008-02-02">
                                                            <span class="time__month">{{ $proceso->nombre_proceso }}</span>
                                                        </time>
                                                    </header>
                                                    <div class="card__content">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <p>
                                                                    Gasto total en insumos: S/
                                                                    {{ $proceso->gasto_total_insumos }}
                                                                </p>
                                                                <p>
                                                                    Gasto total en maquinarias: S/
                                                                    {{ $proceso->gasto_total_maquinarias }}
                                                                </p>
                                                                <p>
                                                                    Gasto total en colaboradores: S/
                                                                    {{ $proceso->gasto_total_colaboradores }}
                                                                </p>
                                                                <br>
                                                                <div class="acciones d-flex">
                                                                    <a href="{{ route('produccion.detalle.proceso', $proceso->id) }}"
                                                                        class="btn btn-success mr-2">
                                                                        Ver más detalles
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('produccion.eliminar.proceso', $proceso->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="cursor-pointer fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                @php
                                                                    $total_gastos = $proceso->gasto_total_insumos + $proceso->gasto_total_maquinarias + $proceso->gasto_total_colaboradores;
                                                                @endphp
                                                                <p class="text-primary text-center"><b>Total de gastos del
                                                                        proceso:</b>
                                                                </p>
                                                                <h2 class="text-center">S/ {{ $total_gastos }}</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
