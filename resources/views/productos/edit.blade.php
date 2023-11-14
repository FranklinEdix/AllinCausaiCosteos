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
                                    <h5 class="mb-0">Editar producto</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('productos.update', $producto->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="categoria">Categoría: </label>
                                        <select name="categoria" id="categoria" required class="form-control">
                                            <option value="{{ $producto->id_categoria }}" selected>
                                                {{ $producto->nombre_categoria }}
                                            </option>
                                            @foreach ($categorias as $categoria)
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @if ($categoria->id == $producto->id_categoria)
                                                    @continue
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                @endif
                                                @if ($i == 0)
                                                    @continue
                                                @else
                                                    <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('categoria')
                                            <small class="text-danger">{{ $message }}</small>
                                            <br>
                                        @enderror

                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ $producto->name }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                            <br>
                                        @enderror

                                        <label for="precio_unitario">Precio unitario: </label>
                                        <input type="number" name="precio_unitario" class="form-control"
                                            value="{{ $producto->precio_unitario }}" step="0.001" required>
                                        @error('precio_unitario')
                                            <small class="text-danger">{{ $message }}</small>
                                            <br>
                                        @enderror

                                        <label for="cantidad">Cantidad: </label>
                                        <input type="number" name="cantidad" class="form-control"
                                            value="{{ $producto->cantidad }}" required>
                                        @error('cantidad')
                                            <small class="text-danger">{{ $message }}</small>
                                            <br>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Actualizar</button>
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
