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
                                    <h5 class="mb-0">Editar producción</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('produccion.update', $produccion->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ $produccion->nombre }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="presentacion">Presentación </label>
                                        <input type="text" name="presentacion" class="form-control"
                                            value="{{ $produccion->presentacion }}" required>
                                        @error('presentacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="descripcion">Descripción: </label>
                                        <input type="text" name="descripcion" class="form-control"
                                            value="{{ $produccion->descripcion }}" required>
                                        @error('descripcion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="producto_final">Producto Final: </label>
                                        <input type="text" name="producto_final" class="form-control"
                                            value="{{ $produccion->producto_final }}" required>
                                        @error('producto_final')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="cantidad_producto_final">Cantidad de Producto Final: </label>
                                        <input type="number" name="cantidad_producto_final" class="form-control"
                                            value="{{ $produccion->cantidad_producto_final }}" required>
                                        @error('cantidad_producto_final')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Actualizar</button>
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
