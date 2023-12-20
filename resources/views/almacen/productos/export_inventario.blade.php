<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
</head>

<body>
    <div class="">
        <h1 style="text-align: center;">{{ $titulo }}</h1>
        <h3>Producto: {{ $producto->name }}</h3>
        <h3>Stock Actual: {{ $detalle_producto->cantidad }}</h3>

    </div>
    <table style="width: 100% !important; text-align: center;">
        <thead>
            <tr style="background-color: #198754; color: #fff;">
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventario as $value)
                <tr>
                    <td>{{ $value->hora_registro }}</td>
                    <td>
                        @if ($value->tipo == 1)
                            Ingreso
                        @else
                            Salida
                        @endif
                    </td>
                    <td>{{ $value->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
