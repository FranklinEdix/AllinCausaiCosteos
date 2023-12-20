<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioExport implements FromCollection, WithHeadings
{
    protected $inventario;

    public function __construct(array $inventario)
    {
        $this->inventario = $inventario;
    }

    public function collection()
    {
        // Formatea los datos para incluir solo los campos deseados
        $formattedData = collect($this->inventario)->map(function ($item) {
            $tipo = $item['tipo'] == 1 ? 'Ingreso' : ($item['tipo'] == 2 ? 'Salida' : 'Otro');
            return [
                'Fecha' => date('Y-m-d H:i:s', strtotime($item['created_at'])), // Ajusta el formato según tus necesidades
                'Tipo' => $tipo,
                'Cantidad' => $item['cantidad'],
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        // Encabezados para las columnas en el archivo Excel
        return [
            'Fecha',
            'Tipo',
            'Cantidad',
        ];
    }
}
