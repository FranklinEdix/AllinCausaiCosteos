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
                                    <h5 class="mb-0">Registrar nuevo producto</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="categoria">Categoría: </label>
                                        <select name="categoria" id="categoria" required class="form-control">
                                            <option value="{{ null }}" selected disabled>Seleccione una categoría
                                            </option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoria')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="presentacion_producto">Presentación: </label>
                                        <input type="text" name="presentacion_producto" class="form-control"
                                            value="{{ old('presentacion_producto') }}" required>
                                        @error('presentacion_producto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="precio_unitario">Precio unitario: </label>
                                        <input type="number" name="precio_unitario" class="form-control"
                                            value="{{ old('precio_unitario') }}" step="0.001" required>
                                        @error('precio_unitario')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="cantidad">Cantidad: </label>
                                        <input type="number" name="cantidad" class="form-control"
                                            value="{{ old('cantidad') }}" required>
                                        @error('cantidad')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger"
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
