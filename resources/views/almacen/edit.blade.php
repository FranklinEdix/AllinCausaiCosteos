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
                                    <h5 class="mb-0">Editar almacen</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('almacen.update', $almacen->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ $almacen->name }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="descripcion">Descripción: </label>
                                        <input type="text" name="descripcion" class="form-control"
                                            value="{{ $almacen->descripcion }}" required>
                                        @error('descripcion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                        <a href="{{ route('almacen.index') }}" class="btn btn-danger"
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
