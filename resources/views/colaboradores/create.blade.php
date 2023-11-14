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
                                    <h5 class="mb-0">Registrar nuevo colaborador</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <form action="{{ route('colaboradores.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4">
                                        <label for="nombre">Nombres: </label>
                                        <input type="text" name="nombre" class="form-control"
                                            value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="apellido">Apellidos: </label>
                                        <input type="text" name="apellido" class="form-control"
                                            value="{{ old('apellido') }}">
                                        @error('apellido')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="dni_carentextrangeria">DNI / Canet de Extrangería: </label>
                                        <input type="number" name="dni_carentextrangeria" class="form-control"
                                            value="{{ old('dni_carentextrangeria') }}">
                                        @error('dni_carentextrangeria')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="email">Correo: </label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="phone">Telefono: </label>
                                        <input type="number" name="phone" class="form-control"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="address">Dirección: </label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="area">Area Empresa: </label>
                                        <select name="area" class="form-control" required>
                                            <option value="{{ null }}" selected disabled>Seleccione un área
                                            </option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('area')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <label for="sueldo_mensual">Sueldo mensual (En soles): </label>
                                        <input type="number" name="sueldo_mensual" class="form-control"
                                            value="{{ old('sueldo_mensual') }}" step="0.001" required>
                                        @error('sueldo_mensual')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex p-4">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <a href="{{ route('colaboradores.index') }}" class="btn btn-danger"
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
