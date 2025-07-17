<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Cliente::all()->map(function ($cliente) {
            return [
                'tipo_documento' => $cliente->tipo_documento,
                'numero_documento' => $cliente->numero_documento,
                'nombres' => $cliente->nombres,
                'apellidos' => $cliente->apellidos,
                'telefono' => $cliente->telefono,
                'direccion' => $cliente->direccion,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tipo de Documento',
            'Número de Documento',
            'Nombres',
            'Apellidos',
            'Teléfono',
            'Dirección',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:F' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
