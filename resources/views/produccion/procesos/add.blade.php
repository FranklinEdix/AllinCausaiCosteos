@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Registrar nueva producción</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('produccion.agregar.proceso', $id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="codigo_proceso">Código Proceso: </label>
                                        <input type="text" name="codigo_proceso" class="form-control"
                                            value="{{ uniqid('proceso-') }}" required readonly>
                                        @error('codigo_proceso')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="nombre">Nombre Proceso: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="duracion_proceso">Duración del Proceso (En horas): </label>
                                        <input type="text" name="duracion_proceso" class="form-control"
                                            value="{{ old('duracion_proceso') }}" required>
                                        @error('duracion_proceso')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="insumos">Insumos: </label>
                                        <br>
                                        <a href="{{ route('insumos.index') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                            type="button" target="__blanck">Ver Todos los insumos</a>
                                        @foreach ($insumos as $insumo)
                                            <div class="row">
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="insumos-{{ $insumo->id }}" name="insumos[]"
                                                            value="{{ $insumo->id }}">
                                                        <label class="form-check-label"
                                                            for="insumos-{{ $insumo->id }}">{{ $insumo->name }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 mt-2">
                                                    <input type="number" class="form-control"
                                                        name="cantidad[{{ $insumo->id }}]" value="{{ old('cantidad') }}"
                                                        placeholder="Cantidad: Ingrese cantidad dependiendo a la presentación">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <input type="number" class="form-control"
                                                        name="new_precio_maquina[{{ $insumo->id }}]"
                                                        value="{{ old('new_precio_maquina') }}"
                                                        placeholder="Precio: Ingrese el precio, solo si el precio varió">
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('insumos')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="maquinarias">Maquinarias: </label>
                                        <br>
                                        <a href="{{ route('maquinarias.index') }}"
                                            class="btn bg-gradient-primary btn-sm mb-0" type="button" target="__blanck">Ver
                                            Todas las Maquinarias</a>
                                        @foreach ($maquinarias as $maquinaria)
                                            <div class="row">
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="maquinarias-{{ $maquinaria->id }}" name="maquinarias[]"
                                                            value="{{ $maquinaria->id }}">
                                                        <label class="form-check-label"
                                                            for="maquinarias-{{ $maquinaria->id }}">{{ $maquinaria->nombre }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 mt-2">
                                                    <input type="number" class="form-control"
                                                        name="new_precio_maquina[{{ $maquinaria->id }}]"
                                                        value="{{ old('new_precio_maquina') }}"
                                                        placeholder="Gasto: Ingrese el gasto por hora, solo si el gasto varió">
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('maquinarias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="colaboradores">Colaboradores: </label>
                                        <br>
                                        <a href="{{ route('colaboradores.index') }}"
                                            class="btn bg-gradient-primary btn-sm mb-0" type="button" target="__blanck">Ver
                                            Todos los Colaboradores</a>
                                        @foreach ($colaboradores as $colaborador)
                                            <div class="row">
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="colaboradores-{{ $colaborador->id }}"
                                                            name="colaboradores[]" value="{{ $colaborador->id }}">
                                                        <label class="form-check-label"
                                                            for="colaboradores-{{ $colaborador->id }}">{{ $colaborador->name }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 mt-2">
                                                    <input type="number" class="form-control"
                                                        name="new_precio_colaborador[{{ $colaborador->id }}]"
                                                        value="{{ old('new_precio_colaborador') }}"
                                                        placeholder="Pago: Ingrese el pago por hora, solo si el pago varió">
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('colaboradores')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('produccion.index') }}" class="btn btn-danger"
                                            style="margin-left: 5px;">Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
