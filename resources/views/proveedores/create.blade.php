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
                                    <h5 class="mb-0">Registrar nuevo proveedor</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('proveedores.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="ruc">RUC: </label>
                                        <input type="number" class="form-control" name="ruc"
                                            value="{{ old('ruc') }}" required>
                                        @error('ruc')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="nombre">Nombre: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="direccion">Dirección legal: </label>
                                        <input type="text" name="direccion" class="form-control"
                                            value="{{ old('direccion') }}" required>
                                        @error('direccion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="name_contacto">Nombre del contacto: </label>
                                        <input type="text" name="name_contacto" class="form-control"
                                            value="{{ old('name_contacto') }}" required>
                                        @error('name_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="email">Correo: </label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="telefono">teléfono: </label>
                                        <input type="text" name="telefono" class="form-control"
                                            value="{{ old('telefono') }}" required>
                                        @error('telefono')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="direc_contacto">Dirección del contacto: </label>
                                        <input type="text" name="direc_contacto" class="form-control"
                                            value="{{ old('direc_contacto') }}" required>
                                        @error('direc_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="descripcion">Descripción </label>
                                        <input type="text" name="descripcion" class="form-control"
                                            value="{{ old('descripcion') }}" required>
                                        @error('descripcion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('proveedores.index') }}" class="btn btn-danger"
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
