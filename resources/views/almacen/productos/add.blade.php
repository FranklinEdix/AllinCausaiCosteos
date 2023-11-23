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
                                    <h5 class="mb-0">Agregar producto</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('almacen.add.producto', $almacen->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="producto">Producto: </label>
                                        <select name="producto" id="" class="form-control">
                                            <option value="{{ null }}" selected disabled>Selecione un producto
                                            </option>
                                            @foreach ($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('producto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="proveedor">Proveedor: </label>
                                        <select name="proveedor" id="" class="form-control">
                                            <option value="{{ null }}" selected disabled>Seleccione un proveedor
                                            </option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('proveedor')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="cantidad">Cantidad: </label>
                                        <input type="number" name="cantidad" class="form-control"
                                            value="{{ old('cantidad') }}" required>
                                        @error('cantidad')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="presentacion">Presentación: </label>
                                        <input type="text" name="presentacion" class="form-control"
                                            value="{{ old('presentacion') }}" required>
                                        @error('presentacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="doc">Documento Referencial, ingrese link del archivo drive:
                                        </label>
                                        <input type="text" name="doc" class="form-control"
                                            value="{{ old('doc') }}" required>
                                        @error('doc')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror


                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('almacen.show', $almacen->id) }}" class="btn btn-danger"
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
