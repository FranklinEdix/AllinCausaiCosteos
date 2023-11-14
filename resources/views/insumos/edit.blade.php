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
                                    <h5 class="mb-0">Editar insumo</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('insumos.update', $insumo->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ $insumo->name }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="presentacion">Presentación: </label>
                                        <select name="presentacion" id="" class="form-control" required>
                                            <option value="{{ $insumo->presentacion }}" selected>
                                                {{ ucfirst($insumo->presentacion) }}</option>
                                            @foreach ($presentaciones as $presentacion)
                                                <option value="{{ $presentacion }}">{{ ucfirst($presentacion) }}</option>
                                            @endforeach
                                        </select>
                                        @error('presentacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="precio_presentacion">Precio por presentación (en soles): </label>
                                        <input type="number" name="precio_presentacion" class="form-control"
                                            value="{{ $insumo->precio_presentacion }}" step="0.001" required>
                                        @error('precio_presentacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Actualiar</button>
                                        <a href="{{ route('insumos.index') }}" class="btn btn-danger"
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
